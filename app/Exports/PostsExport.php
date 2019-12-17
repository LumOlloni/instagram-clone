<?php

namespace App\Exports;


use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PostsExport implements FromQuery , WithHeadings , WithMapping , WithEvents
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function query()
    {
        return  Post::with(['user' , 'tags' , 'likes' , 'comments'])->where('user_id' , Auth::id());
    }

    public function map($post): array
    {
        return [
            $post->id,
            $post->description,
            $post->comments->map(function ($q){
                return $q->body;
            }),
            $post->user->name,
            $post->tags->map(function ($q) {
                return $q->name;
            }),
            $post->likes->count(),
            Carbon::parse($post->created_at)->toFormattedDateString(),
            Carbon::parse($post->updated_at)->toFormattedDateString(),
        ];
    }

    public function headings(): array
    {
        return [
            'Id',
            'Description',
            'Comments',
            'User',
            'Tags',
            'Likes',
            'Created_at',
            'Updated_at'
        ];
    }

    public function registerEvents():array  {

        $styleColumns = [
            'font' => [
                'bold' =>true
            ]
        ];

        return [

            BeforeSheet::class => function (BeforeSheet $event) use ($styleColumns) {
                $event->sheet->getStyle('A:H')->applyFromArray($styleColumns);
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(15);
                $event->sheet->getColumnDimension('C')->setWidth(100);
                $event->sheet->getColumnDimension('D')->setWidth(17);
                $event->sheet->getColumnDimension('E')->setWidth(30);
                $event->sheet->getColumnDimension('F')->setWidth(5);
                $event->sheet->getColumnDimension('G')->setWidth(15);
                $event->sheet->getColumnDimension('H')->setWidth(15);
            }
        ];
    }
}
