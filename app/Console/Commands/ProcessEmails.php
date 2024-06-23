<?php
namespace App\Console\Commands;

use PhpImap\Exceptions\ConnectionException;
use Illuminate\Console\Command;
use PhpImap\Mailbox;

class ProcessEmails extends Command
{
    protected $signature = 'app:process-emails 
                            {--unread : Process unread emails}
                            {--all : Process all emails}
                            {--since= : Process emails since date (YYYYMMDD)}
                            {--before= : Process emails before date (YYYYMMDD)}
                            {--folder= : Destination folder for processed emails}';
    protected $description = 'Process unread emails';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // IMAP configuration
        $host = env('IMAP_HOST');
        $port = env('IMAP_PORT');
        $encryption = env('IMAP_ENCRYPTION');
        $username = env('IMAP_USERNAME');
        $password = env('IMAP_PASSWORD');
        $imapPath = '{' . $host . ':' . $port . '/imap/' . $encryption . '}INBOX';

        $mailbox = new Mailbox($imapPath, $username, $password);
        $mailbox->setAttachmentsIgnore(true);

        try {
            // Determinar criterio de búsqueda
            if ($this->option('all')) {
                $emails = $mailbox->searchMailbox('ALL');
            } elseif ($this->option('since')) {
                $since = $this->option('since');
                $criteria = 'SINCE "' . $since . '"';
                if ($this->option('before')) {
                    $before = $this->option('before');
                    $criteria .= ' BEFORE "' . $before . '"';
                }
                $emails = $mailbox->searchMailbox($criteria);
            } else {
                // Por defecto, leer correos no leídos
                $emails = $mailbox->searchMailbox('UNSEEN');
            }

            // Configurar carpeta de destino
            $defaultFolder = 'Procesados';
            $folder = $this->option('folder') ?? $defaultFolder;
            $this->info('Emails found: ' . count($emails));

            foreach ($emails as $mail) {
                $email = $mailbox->getMail($mail, true);
                $fromEmail = $email->fromAddress;
                $subject = $email->subject;
                $bodyText = $email->textPlain ? $email->textPlain : $this->convertHtmlToText($email->textHtml);
                $bodyText = $this->cleanText($bodyText);

                // Procesar según el remitente
                if ($fromEmail == 'bancaporinternet@empresas.interbank.pe') {
                    $this->processInterbankEmail($subject, $bodyText);
                    $mailbox->moveMail($mail, $folder);
                } elseif ($fromEmail == 'notificaciones@notificacionesbcp.com.pe') {
                    $this->processBCPEmail($subject, $bodyText);
                    $mailbox->moveMail($mail, $folder);
                }
            }

        } catch (ConnectionException $ex) {
            $this->error("IMAP connection failed: " . $ex->getMessage());
            return;
        } catch (\Exception $ex) {
            $this->error("Error: " . $ex->getMessage());
            return;
        } finally {
            $mailbox->disconnect();
        }
    }


    private function convertHtmlToText($html)
    {
        $html = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $html);
        $text = strip_tags(html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        return $text;
    }

    private function cleanText($text)
    {
        $text = str_replace(["\r", "\n", "\t"], ' ', $text);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        return $text;
    }

    private function processInterbankEmail($subject, $bodyText)
    {
        if ($subject == 'Constancia de Transferencia a terceros') {
            // Patterns to extract necessary data
            $patterns = [
                'request_number' => '/Número de solicitud: (\d+)/',
                'date' => '/Fecha: (\d{2}\/\d{2}\/\d{4})/',
                'time' => '/Hora: (\d{1,2}:\d{2} (A\.M\.|P\.M\.))/i',
                'from' => '/De:\s*([^\n\r]+)\s*Para:/s',
                'to' => '/Para:\s*([^\n\r]+)\s*Cuenta de cargo:/s',
                'account_debit' => '/Cuenta de cargo:\s*([^\n\r]+)\s*Cuenta de destino:/s',
                'account_destination' => '/Cuenta de destino:\s*([^\n\r]+)\s*Estado:/s',
                'status' => '/Estado:\s*([^\n\r]+)\s*Monto:/s',
                'amount' => '/Monto:\s*([^\n\r]+)\s*Para cualquier/s',
            ];

            $data = [];

            foreach ($patterns as $key => $pattern) {
                preg_match($pattern, $bodyText, $matches);
                $data[$key] = isset($matches[1]) ? trim($matches[1]) : '';
            }

            if (!empty($data['amount'])) {
                $data['amount'] = str_replace(['S/', ',', '.'], ['', '', '.'], $data['amount']);
            }

            echo "Result:\n";
            print_r($data);

            return $data;
        }

        return null;
    }

    private function processBCPEmail($subject, $bodyText)
    {
        if ($subject == 'Transferencia a su favor desde Telecrédito BCP') {
            // Patterns to extract necessary data
            $patterns = [
                'operation_type' => '/Tipo de operación\s*([^\n\r]+)\s*Fecha/',
                'operation_number' => '/Número de operación (\d+)/',
                'date_time' => '/Fecha y hora\s+(\d{2}\/\d{2}\/\d{4}\s+-\s+\d{1,2}:\d{2})/i',
                'ordering_company' => '/Empresa ordenante\s+([\w\s.]+)\s+Cuenta/',
                'origin_account' => '/Cuenta\s+(\d+-[\w-]+)\s+Tipo de cuenta/',
                'beneficiary' => '/Beneficiario\s+([\w\s.]+)\s+Cuenta/',
                'destination_account' => '/Cuenta\s+(\d+-[\w-]+)\s+Monto/',
                'amount' => '/Monto\s+(S\/ [\d,.]+)/',
            ];

            $data = [];

            foreach ($patterns as $key => $pattern) {
                preg_match($pattern, $bodyText, $matches);
                $data[$key] = isset($matches[1]) ? trim($matches[1]) : '';
            }

            if (!empty($data['amount'])) {
                $data['amount'] = str_replace(['S/', ',', '.'], ['', '', '.'], $data['amount']);
            }

            echo "BCP Transaction Data:\n";
            print_r($data);

            return $data;
        }

        return null;
    }

}
