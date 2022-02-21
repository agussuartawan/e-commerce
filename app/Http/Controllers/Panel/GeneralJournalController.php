<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
use App\Models\GeneralJournal;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Carbon\Carbon;

class GeneralJournalController extends Controller
{
    public function index()
    {
        $start = Carbon::now()->startOfMonth()->format('d-m-Y');
        $end = Carbon::now()->format('d-m-Y');
        $dateFilter = $start . ' / ' . $end;
        return view('panel.journal.index', compact('dateFilter', 'start', 'end'));
    }

    public function create()
    {
        return view('panel.journal.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required'],
            'account_id' => ['required'],
            'debit' => ['required'],
            'credit' => ['required'],
        ]);
        foreach($validated['account_id'] as $key => $account_id){
            $journal[] = GeneralJournal::create([
                'date' => $validated['date'][$key],
                'account_id' => $validated['account_id'][$key],
                'debit' => $validated['debit'][$key],
                'credit' => $validated['credit'][$key],
            ]);
        }

        return $journal;
    }

    public function edit(GeneralJournal $journal)
    {
        $accounts = Account::pluck('name', 'id');
        return view('include.journal.edit', compact('journal', 'accounts'));
    }

    public function update(GeneralJournal $journal, Request $request)
    {
        $messages = [
            'date.required' => 'Tanggal tidak boleh kosong!',
            'account_id.required' => 'Akun tidak boleh kosong!',
            'debit.numeric' => 'Jumlah debet harus berupa angka!',
            'credit.numeric' => 'Jumlah kredit harus berupa angka!',
        ];
        $validated = $request->validate([
            'date' => ['required'],
            'account_id' => ['required'],
            'debit' => ['numeric'],
            'credit' => ['numeric'],
        ], $messages);
        $journal->update($validated);

        return $journal;
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

                    $date['from'] = Carbon::parse($from)->format('Y-m-d');
                    $date['to'] = Carbon::parse($to)->format('Y-m-d');
                    $instance->whereBetween('date', $date);
                }
                if (!empty($request->search)) {

                    $instance->whereHas('account', function($query) use ($request){
                        $search = $request->search;
                        $query->where('name', 'like', "%$search%")
                        ->orWhere('account_number', 'like', "%$search%");
                    })
                    ->with(['account' => function($query) use ($request){
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
}
