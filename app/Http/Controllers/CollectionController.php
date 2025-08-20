<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Collection; // Asegúrate de que el nombre de tu modelo 'Collection' sea correcto
use Barryvdh\DomPDF\Facade\Pdf; // Para exportar a PDF
use Illuminate\Support\Facades\Response; // Para exportar a Excel (CSV)

class CollectionController extends Controller
{
    /**
     * Muestra el dashboard principal del usuario con historial y calendario.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Avatar dinámico basado en la inicial del nombre del usuario
        $initial = strtoupper(substr($user->name, 0, 1));
        $avatarUrl = "https://ui-avatars.com/api/?name={$initial}&background=random&color=fff";

        // Historial de recolecciones del usuario autenticado, ordenado por fecha descendente
        $history = $user->collections()
                        ->orderBy('scheduled_date', 'desc')
                        ->get();

        // Preparar eventos para el calendario FullCalendar
        $calendarEvents = $history->map(function ($item) {
            return [
                'title' => $item->waste_type . ' - ' . $item->kilos . 'kg',
                'start' => $item->scheduled_date,
                'color' => $this->getEventColor($item->waste_type),
            ];
        });

        return view('dashboard.user-dashboard', compact('user', 'avatarUrl', 'history', 'calendarEvents'));
    }

    /**
     * Guarda una nueva recolección programada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'waste_type' => 'required|string',
            'scheduled_date' => 'required|date',
            'kilos' => 'required|integer|min:1', // Validación para asegurar que los kilos son un número entero positivo
        ]);

        $kilos = $request->kilos;
        $points = $kilos * 5; // Cálculo de puntos basado en los kilos

        // Crear una nueva entrada de recolección en la base de datos
        Collection::create([
            'user_id' => Auth::id(), // Asigna la recolección al usuario autenticado
            'waste_type' => $request->waste_type,
            'scheduled_date' => $request->scheduled_date,
            'status' => 'pendiente', // Estado inicial de la recolección
            'kilos' => $kilos,
            'points' => $points,
        ]);

        // Redirigir al dashboard con un mensaje de éxito
        return redirect()->route('dashboard')
                         ->with('success', '¡Recolección programada exitosamente!');
    }

    /**
     * Obtiene el color del evento para el calendario basado en el tipo de residuo.
     *
     * @param string $wasteType
     * @return string
     */
    private function getEventColor($wasteType)
    {
        switch ($wasteType) {
            case 'Orgánico': return '#66bb6a'; // Verde
            case 'Inorgánico': return '#42a5f5'; // Azul
            case 'Peligroso': return '#ef5350'; // Rojo
            default: return '#9e9e9e'; // Gris por defecto
        }
    }

    /**
     * Exporta el historial de recolecciones del usuario a un archivo PDF.
     * Requiere el paquete 'barryvdh/laravel-dompdf'.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exportPdf()
    {
        // Obtener las recolecciones del usuario autenticado
        $history = Auth::user()->collections;

        // Cargar la vista 'pdfs.collections_report' con los datos del historial
        $pdf = Pdf::loadView('pdfs.collections_report', compact('history'));

        // Descargar el PDF con un nombre de archivo específico
        return $pdf->download('historial_recolecciones_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Exporta el historial de recolecciones del usuario a un archivo Excel (CSV).
     * No requiere paquetes externos, genera un CSV directamente.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportExcel()
    {
        // Obtener las recolecciones del usuario autenticado
        $collections = Auth::user()->collections()->get();

        $filename = 'historial_recolecciones_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // Definir las columnas para el CSV
        $columns = ['ID', 'Fecha', 'Tipo de Residuo', 'Kilos', 'Puntos', 'Estado'];

        $callback = function() use ($collections, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Escribir los encabezados

            foreach ($collections as $collection) {
                // Preparar los datos de cada fila
                $row = [
                    $collection->id,
                    \Illuminate\Support\Carbon::parse($collection->scheduled_date)->format('Y-m-d'),
                    $collection->waste_type,
                    $collection->kilos,
                    $collection->points,
                    ucfirst($collection->status), // Capitalizar el estado
                ];
                fputcsv($file, $row); // Escribir la fila
            }
            fclose($file);
        };

        // Devolver la respuesta como un stream (flujo) para la descarga del archivo
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Reprograma una recolección existente.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reprogram(Request $request, $id)
    {
        // Validar que la nueva fecha sea requerida y válida
        $request->validate([
            'scheduled_date' => 'required|date'
        ]);

        // Encontrar la recolección por ID y verificar que pertenezca al usuario autenticado
        $collection = Collection::where('id', $id)
                                ->where('user_id', Auth::id())
                                ->firstOrFail(); // Si no se encuentra, lanzará una excepción 404

        // Actualizar la fecha programada y cambiar el estado a 'reprogramada'
        $collection->scheduled_date = $request->scheduled_date;
        $collection->status = 'reprogramada';
        $collection->save();

        // Redirigir al dashboard con un mensaje de éxito
        return redirect()->route('dashboard')
                         ->with('success', '¡Recolección reprogramada con éxito!');
    }
}
