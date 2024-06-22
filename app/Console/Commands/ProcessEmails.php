<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class ProcessEmails extends Command
{

    protected $signature = 'app:process-emails';
    protected $description = 'Process unread emails';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Configurar conexión IMAP
        $imapPath = '{' . env('IMAP_HOST') . ':' . env('IMAP_PORT') . '/' . env('IMAP_ENCRYPTION') . '}' . env('IMAP_MAILBOX');
        $imapStream = imap_open($imapPath, env('IMAP_USERNAME'), env('IMAP_PASSWORD'));

        if (!$imapStream) {
            $this->error('No se pudo conectar al servidor IMAP.');
            return;
        }

        // Obtener correos no leídos
        $emails = imap_search($imapStream, 'UNSEEN');

        if (!$emails) {
            $this->info('No hay correos nuevos para procesar.');
            imap_close($imapStream);
            return;
        }

        // Procesar correos
        foreach ($emails as $emailId) {
            $headerInfo = imap_headerinfo($imapStream, $emailId);
            $from = $headerInfo->from[0]->mailbox . '@' . $headerInfo->from[0]->host;
            $subject = $this->decodeMimeStr($headerInfo->subject);
            $date = Carbon::parse($headerInfo->date);

            $body = trim(utf8_encode(quoted_printable_decode(imap_fetchbody($imapStream, $emailId, 1))));
            
            // if (preg_match('/^([a-zA-Z0-9]{76} )+[a-zA-Z0-9]{76}$/', $body)) {
            //     $body = base64_decode($body);
            // }

            // Procesar el correo según el remitente y el asunto
            // $this->processEmail($from, $subject, $body, $date);

            $this->info('Correo procesado correctamente.');
            $this->info('Fecha: ' . $date->format('Y-m-d H:i:s'));
            $this->info('Remitente: ' . $from);
            $this->info('Asunto: ' . $subject);
            $this->info('Cuerpo: ' . $body);

            // Marcar correo como leído
            imap_setflag_full($imapStream, $emailId, "\\Seen");
        }

        // Cerrar conexión IMAP
        imap_close($imapStream);

        $this->info('Correos procesados correctamente.');
    }


    private function decodeMimeStr($string, $charset = 'UTF-8')
    {
        $elements = imap_mime_header_decode($string);
        $decodedStr = '';

        foreach ($elements as $element) {
            if (isset($element->charset) && strtolower($element->charset) !== 'default') {
                $decodedStr .= iconv($element->charset, $charset, $element->text);
            } else {
                $decodedStr .= $element->text;
            }
        }

        return $decodedStr;
    }

    private function extractTextFromBody($body)
{
    // Convertir el cuerpo del correo a texto plano
    $text = imap_utf8($body); // Convertir a UTF-8 si es necesario
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = preg_replace('/\R/u', ' ', $text); // Reemplazar saltos de línea con espacios
    $text = strip_tags($text); // Eliminar etiquetas HTML
    $text = htmlspecialchars_decode($text, ENT_QUOTES | ENT_HTML5); // Decodificar caracteres especiales HTML
    $text = trim(preg_replace('/\s+/', ' ', $text)); // Eliminar espacios en blanco adicionales

    return $text;
}



    private function processEmail($from, $subject, $body, $date)
    {
        // Procesar correos según remitente y asunto
        if ($from === 'notificaciones@notificacionesbcp.com.pe') {
            // Procesar correos de notificaciones BCP
            if ($subject === 'Transferencia a su favor desde Telecrédito BCP') {
                $this->processBcpNotificationsEmail($body, $date);
            }
        } elseif ($from === 'bancaporinternet@empresas.interbank.pe') {
            // Procesar correos de notificaciones Interbank
            if ($subject === 'Constancia de Transferencia a terceros') {
                $this->processInterbankCompanysEmail($body, $date);
            }
        }
    }



    private function processBcpNotificationsEmail($body, $date)
    {
        $cuentaRegex = '/Cuenta\s*([\d-]+)/';
        $messageType = $this->extractDataFromBody($body, '/Mensaje\s*(.*)/');
        $startsWithKeyword = preg_match('/Si Ud\. es cliente de Telecrédito/', $messageType);
        preg_match_all($cuentaRegex, $body, $matches);
        $cuenta1 = $matches[1][0] ?? null;
        $cuenta2 = $matches[1][1] ?? null;

        $amountString = $this->extractDataFromBody($body, '/S\/(.*)/');
        $amountNumeric = floatval(str_replace(',', '', $amountString));

        // Restar 5 horas a la fecha
        $adjustedDate = $date->subHours(5);

        $operationNumber = $this->extractDataFromBody($body, '/Número de operación\s*(.*)/');

        // Validar si el registro ya existe
        // $existingNotification = BcpNotification::where('operationNumber', $operationNumber)
        //     ->where('dateTime', $adjustedDate)
        //     ->first();

        // if (!$existingNotification) {
        //     BcpNotification::create([
        //         'operationType' => $this->extractDataFromBody($body, '/Tipo de operación\s*(.*)/'),
        //         'dateTime' => $adjustedDate,
        //         'operationNumber' => $operationNumber,
        //         'orderingCompany' => 'BUSINESS ADMINISTRATION SAC',
        //         'account' => $this->extractDataFromBody($body, '/Cuenta\s*(.*)/'),
        //         'accountType' => $this->extractDataFromBody($body, '/Tipo de cuenta\s*(.*)/'),
        //         'beneficiary' => str_replace(['Ñ', '-'], ['N', ' '], $this->extractDataFromBody($body, '/Beneficiario\s*(.*)/')),
        //         'destinationAccount' => str_replace('-', '', $cuenta2),
        //         'amount' => $amountNumeric,
        //         'reference' => $this->extractDataFromBody($body, '/Referencia\s*(.*)/'),
        //         'message' => $startsWithKeyword ? null : $messageType,
        //         'bank' => 'BCP',
        //         'validacion' => 'No Validado',
        //     ]);
        // }
    }

    private function processInterbankCompanysEmail($body, $date)
    {
        $amountString = $this->extractDataFromBody($body, '/S\/(.*)/');
        $amountNumeric = floatval(str_replace(',', '', $amountString));

        // Restar 5 horas a la fecha
        $adjustedDate = $date->subHours(5);

        $regex = '/Para:(.*?)Cuenta de cargo:/s';
        preg_match($regex, $body, $match);
        $textoExtraido2 = $match[1] ?? null;

        $orderingCompanyRegex = '/De:\s*(.*?)(?=Para:)/';
        $beneficiaryRegex = '/Para:\s*(.*?)Cuenta\s+de\s+cargo:/s';
        $accountChargeRegex = '/Cuenta\s+de\s+cargo:\s*(.*?)Cuenta\s+de\s+destino:/';
        $accountDestinationRegex = '/Cuenta\s+de\s+destino:\s*([\w\s-]+)(?!\SEstado)/';
        $statusRegex = '/Estado:\s*(.*?)Monto:/';
        $numberApplicationRegex = '/Número de solicitud:\s*(.*)/';

        $orderingCompany = $this->extractDataFromBody($body, $orderingCompanyRegex);
        $beneficiary = $this->extractDataFromBody($body, $beneficiaryRegex);
        $accountCharge = $this->extractDataFromBody($body, $accountChargeRegex);
        $accountDestination = str_replace('-', '', $this->extractDataFromBody($body, $accountDestinationRegex));
        $status = $this->extractDataFromBody($body, $statusRegex);
        $numberApplication = $this->extractDataFromBody($body, $numberApplicationRegex);

        $beneficiary2 = $beneficiary ?? $textoExtraido2;

        $this->info('Beneficiario: ' . $beneficiary2);
        $this->info('Cuenta de cargo: ' . $accountCharge);
        $this->info('Cuenta de destino: ' . $accountDestination);
        $this->info('Estado: ' . $status);
        $this->info('Número de aplicación: ' . $numberApplication);
        $this->info('Monto: ' . $amountNumeric);
        $this->info('Fecha: ' . $adjustedDate->format('Y-m-d H:i:s'));
        $this->info('Orden de compra: ' . $orderingCompany);


        // Validar si el registro ya existe
        // $existingNotification = InterbankCompany::where('numberApplication', trim($numberApplication))
        //     ->where('dateTime', $adjustedDate)
        //     ->first();

        // if (!$existingNotification) {
        //     InterbankCompany::create([
        //         'orderingCompany' => trim($orderingCompany),
        //         'beneficiary' => str_replace(['Ñ', '-'], ['N', ' '], $beneficiary2),
        //         'accountCharge' => trim($accountCharge),
        //         'accountDestination' => trim(str_replace(['Ahorros Soles', 'Estado'], '', $accountDestination)),
        //         'status' => trim($status),
        //         'numberApplication' => trim($numberApplication),
        //         'amount' => $amountNumeric,
        //         'dateTime' => $adjustedDate,
        //         'bank' => 'Interbank',
        //         'validacion' => 'No Validado',
        //     ]);
        // }
    }
}
