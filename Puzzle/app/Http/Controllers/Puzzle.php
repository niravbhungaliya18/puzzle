<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class Puzzle extends Controller
{
   function index()
   {
   		return view('puzzle');
   }

   function postdata(Request $request)
   {
   		//validation
   		$validation = Validator::make($request->all(), [
                'player1' 		=> 'required',
                'player2'  		=> 'required',
                'coins' 		=> 'required',
                'coin_values' 	=> 'required',
            ]);
        $error_array = array();
        $success_output = '';

        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {	
        	//fetch data from user
        	$coins = $request->get('coins');
			$coin_values= $request->get('coin_values');
			$coin_values = explode(',', $coin_values);
			$player_number1 = $request->get('player1');
			$coins_of_player1 = array();
			$coins_of_player2 = array();
			$player_number2 = $request->get('player2');
			$amount_of_palyer1 = 0;
			$amount_of_palyer2 = 0;

			//puzzle logic
			for($i=0;$i<$coins;$i++){
				if($i%2 ==0){
					$coins_of_player1[$i/2] = $coin_values[$i];
				}
				else{
					$coins_of_player2[$i/2] = $coin_values[$i];
				}
			}
			for($j=0;$j<$coins/2;$j++){
				$amount_of_palyer1 += $coins_of_player1[$j];
				$amount_of_palyer2 += $coins_of_player2[$j];
			}
			if($amount_of_palyer1>$amount_of_palyer2)
			{
				$success_output .= "Player Number : ".$player_number1. " wins<br>";
				$success_output .= "And Coins of Player Number ".$player_number1." are: [ ";
				for ($i=0; $i < $coins/2; $i++) { 
					$success_output .= $coins_of_player1[$i].", ";
				}
				$success_output .= " ]";
			}
			else
			{
				$success_output .= "Player Number : ".$player_number2. " wins<br>";
				$success_output .= "And Coins of Player Number ".$player_number2." are: [ ";
				for ($i=0; $i < $coins/2; $i++) { 
					$success_output .= $coins_of_player2[$i].", ";
				}
				$success_output .= " ]";
			}
        }

        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );

        echo json_encode($output);
   }
}
