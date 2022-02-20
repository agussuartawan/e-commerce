<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Models\GeneralJournal;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class GeneralJournalController extends Controller
{
    public function index()
    {
        return view('panel.journal.index');
    }

    public function create()
    {
        return view('panel.journal.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'date.required' => 'Tanggal tidak boleh kosong!',
            'account_id.required' => 'Akun tidak boleh kosong!',
            'debit.required' => 'Jumlah debet tidak boleh kosong!',
            'debit.numeric' => 'Jumlah debet harus berupa angka!',
            'credit.required' => 'Jumlah kredit tidak boleh kosong!',
            'credit.numeric' => 'Jumlah kredit harus berupa angka!',
        ];
        $validated = $request->validate([
            'date' => ['required'],
            'account_id' => ['required'],
            'debit' => ['required', 'numeric'],
            'kredit' => ['required', 'numeric'],
        ], $messages);
        $journal = GeneralJournal::create($validated);

        return redirect()->route('journals.index')->with('success', 'Jurnal Umum berhasil disimpan');
    }

    public function edit(GeneralJournal $general_journal)
    {
        $messages = [
            'date.required' => 'Tanggal tidak boleh kosong!',
            'account_id.required' => 'Akun tidak boleh kosong!',
            'debit.required' => 'Jumlah debet tidak boleh kosong!',
            'debit.numeric' => 'Jumlah debet harus berupa angka!',
            'credit.required' => 'Jumlah kredit tidak boleh kosong!',
            'credit.numeric' => 'Jumlah kredit harus berupa angka!',
        ];
        $validated = $request->validate([
            'date' => ['required'],
            'account_id' => ['required'],
            'debit' => ['required', 'numeric'],
            'kredit' => ['required', 'numeric'],
        ], $messages);
        $general_journal->update($validated);

        return $general_journal;
    }

    public function getJournalList(Request $request)
    {
        $data  = GeneralJournal::query();

        return DataTables::of($data)
            ->addColumn('debit', function ($data) {
                return 'Rp. ' . rupiah($data->debit);
            })
            ->addColumn('credit', function ($data) {
                return 'Rp. ' . rupiah($data->credit);
            })
            ->addColumn('account_name', function ($data) {
                return $data->account->name;
            })
            ->addColumn('account_number', function ($data) {
                return $data->account->account_number;
            })
            ->addColumn('date', function ($data) {
                return Carbon::parse($data->date)->format('d/m/Y');
            })
            ->addColumn('action', function ($data) {
                $buttons = '<a href="/journals/'. $data->id .'/edit" class="btn btn-sm btn-outline-info btn-block modal-edit" title="Edit Jurnal Umum">Edit</a>';              

                return $buttons;
            })
            ->filter(function ($instance) use ($request) {
                if ($request->dateFilter) {
                    $from = explode(" / ", $request->dateFilter)[0];
                    $to = explode(" / ", $request->dateFilter)[1];

                    $date['from'] = Carbon::parse($from)->startOfDay()->format('Y-m-d H:i:s');
                    $date['to'] = Carbon::parse($to)->endOfDay()->format('Y-m-d H:i:s');
                    $instance->whereBetween('date', $date);
                }
                if (!empty($request->search)) {
                    $instance->with(['account' => function($query) use ($request){
                        $search = $request->search;
                        $query->where('name', 'like', "%$search%")
                        ->orWhere('account_number', 'like', "%$search%");
                    }]);
                }

                return $instance;
            })
            ->rawColumns(['action',' date', 'debit', 'credit','account_name', 'account_number'])
            ->make(true);
    }

    public function searchMonth()
    {
        return $months = [
            ['name' => 'Januari', 'id' => 1],
            ['name' => 'Februari', 'id' => 2],
            ['name' => 'Maret', 'id' => 3],
            ['name' => 'April', 'id' => 4],
            ['name' => 'Mei', 'id' => 5],
            ['name' => 'Juni', 'id' => 6],
            ['name' => 'Juli', 'id' => 7],
            ['name' => 'Agustus', 'id' => 8],
            ['name' => 'September', 'id' => 9],
            ['name' => 'Oktober', 'id' => 10],
            ['name' => 'November', 'id' => 11],
            ['name' => 'December', 'id' => 12],
        ];
    }

    public function searchYear()
    {
        $now_year = date('Y');
        for($i = 2021; $i <= $now_year; $i++){
            $years[] = ['name' => $i,'id' => $i];
        }
        return $years;
    }
}
