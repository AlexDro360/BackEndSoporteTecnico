<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    /**
     * @param string $view   Nombre de la vista Blade.
     * @param array  $data   Datos a pasar a la vista (puede contener 'path_pdf').
     * @param string $prefix Prefijo para el nombre del archivo.
     * @param string $disk   Disco de Laravel donde se guarda.
     * @return string        URL pública del archivo.
     */
    public function generarPdf(string $view, array $data, string $prefix = 'documento', string $disk = 'pdfs'): string
    {
        if (!empty($data['path_pdf'])) {
            $oldFile = basename($data['path_pdf']);

            if (Storage::disk($disk)->exists($oldFile)) {
                Storage::disk($disk)->delete($oldFile);
            }
        }
        
        $pdf = Pdf::loadView($view, $data);

        $filename = $prefix . '_' . time() . '.pdf';

        Storage::disk($disk)->put($filename, $pdf->output());

        return $filename;
    }
}
