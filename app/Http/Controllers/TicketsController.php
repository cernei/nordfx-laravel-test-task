<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketAddRequest;
use App\Http\Services\SmartyService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TicketsController
{
    /**
     * @var SmartyService
     */
    private $smarty;

    public function __construct(SmartyService $smartyService) {
        $this->smarty = $smartyService->getInstance();
    }

    public function showAddForm(Request $request, Response $response)
    {
//        $tickets = DB::table('tickets')->get()->toArray();
//        $result = [];
//        foreach($tickets as $ticket) {
//            $result[] = ['user_number' => $ticket->user_number];
//        }

        $compiled = $this->smarty->fetch('add.tpl', [
            'csrf' => csrf_token(),
            'message' =>  $request->session()->pull('message'),
//            'myTickets' => $result
        ]);

        return $response->setContent($compiled);
    }

    public function addTicket(TicketAddRequest $request)
    {
        DB::table('tickets')->insert([
            'username' => $request->username,
            'user_number' => intval($request->user_number),
            'date_bought' => now(),
        ]);

        $request->session()->flash('message', 'Ticket was added.');

        return redirect()->route('showTicket');
    }

    public function start(Response $response)
    {
        $compiled = $this->smarty->fetch('start.tpl');

        return $response->setContent($compiled);
    }

    public function launch(Request $request, Response $response)
    {
        $totalTicketCount = DB::table('tickets')->count();

        $prizes = [20000 => 1, 5000 => 3, 1000 => 5, 500 => 20];
        $winningNumbers = [];
        foreach ($prizes as $winAmount => $prizeCount) {
            for ($i = 0; $i < $prizeCount; $i++) {
                $winningNumbers[mt_rand(1000000, 9999999)] = $winAmount;
            }
        }
        // snippet for hardcode testing
//        $winningNumbers = [
//            '1234567' => 20000,
//            '2234567' => 5000,
//            '3234567' => 5000,
//            '4234567' => 1000,
//            '5234567' => 1000,
//            '6234567' => 1000,
//            '7234567' => 500,
//            '8234567' => 500,
//            '9234567' => 500,
//        ];
        $tickets = DB::table('tickets')
                    ->whereIn('user_number', array_keys($winningNumbers))
                    ->where('date_bought' , '>=', $request->date_from)
                    ->where('date_bought' , '<=', Carbon::parse($request->date_to)->endOfDay())
                    ->get();

        $ticketsGroupedByNumber = $tickets->groupBy('user_number');

        $result = [];
        foreach ($winningNumbers as $winningNumber => $prize) {
            if (!isset($result[$prize])) {
                $result[$prize] = [];
            }
            $result[$prize][$winningNumber] = null;
            if (isset($ticketsGroupedByNumber[$winningNumber])) {
                $result[$prize][$winningNumber] = $ticketsGroupedByNumber[$winningNumber]
                    ->pluck('username')->unique()->toArray();
            }
            $now = now();
            DB::table('results')->insert([
                'draw_date' => $now,
                'prize' => $prize,
                'winning_number' => $winningNumber,
                'winners' => implode('\n',  $result[$prize][$winningNumber] ?: []),
            ]);
        }

        $compiled = $this->smarty->fetch('launch.tpl', [
            'winningTickets' => $result,
            'totalTicketCount' => $totalTicketCount
        ]);

        return $response->setContent($compiled);
    }

    public function results(Request $request, Response $response)
    {
        $draw = DB::table('results')
            ->select(['draw_date'])
            ->orderBy('draw_date', 'desc')
            ->groupBy(['draw_date'])
            ->first();
        if ($draw) {
            $tickets = DB::table('results')
                ->where('draw_date' , '=', $draw->draw_date)
                ->get();
        }
        $groups = $tickets->groupBy('prize');
        $result = [];
        foreach($groups as $prize => $group) {
            $winningNumberGroups = $group->keyBy('winning_number')->toArray();
            if (!isset($result[$prize])) {
                $result[$prize] = [];
            }
            foreach ($winningNumberGroups as $number => $group2) {
                $result[$prize][$number] = $group2->winners;
            }
        }

        $compiled = $this->smarty->fetch('results.tpl', [
            'draw_date' => $draw->draw_date,
            'winningTickets' => $result,
        ]);

        return $response->setContent($compiled);
    }
}
