<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use App\Models\SystemData;
use Throwable;
use Log;

class DataLoadImport implements ToModel, WithHeadingRow, WithUpserts, WithBatchInserts, WithChunkReading
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {

            $row = array_map('trim', $row);
            if (
                $row['estado'] == 'PAGADO' &&
                (
                    $row['banco_pago'] === 'BCP BUSINESS' ||
                    $row['banco_pago'] === 'INTERBANK BUSINESS'
                ) &&
                !empty($row['fecha_pago'])
            ) {

                $first_name = Str::title(str_replace(['ñ', 'Ñ'], 'n', $row['nombres']));
                $last_name = Str::title(str_replace(['ñ', 'Ñ'], 'n', $row['apellidos']));

                return new SystemData([
                    'cod_transaction' => $row['cod_transaccion'],
                    'request_date' => $row['fecha_solicitud'],
                    'payment_date' => $row['fecha_pago'],
                    'user' => $row['usuario'],
                    'cash_station' => $row['caja'],
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'bank' => $row['banco'],
                    'account_number' => $row['nro_cuenta'],
                    'cci' => $row['cci'],
                    'payment_bank' => $row['banco_pago'],
                    'amount' => $row['monto_s'],
                    'commission' => $row['comision_s'],
                    'operation_number' => $row['nro_operacion'],
                    'status' => $row['estado'],
                    'rejection_reason' => $row['motivo_rechazo'],
                    'payer' => $row['pagador'],
                    'reason' => $row['razon'],
                    'receipt' => $row['comprobante'],
                    'type' => $row['tipo'],
                    'approved_by' => $row['aprobado_por'],
                ]);

            } else {
                return null;
            }

        } catch (Throwable $e) {
            Log::error('Error importing data load: ' . $e->getMessage(), [
                'exception' => $e,
                'row' => $row
            ]);
        }
    }

    /**
     * Define the unique key for upserts.
     * 
     * @return string
     */
    public function uniqueBy()
    {
        return 'cod_transaction';
    }

    /**
     * Define the batch size for inserts.
     * 
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * Define the chunk size for reading.
     * 
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
