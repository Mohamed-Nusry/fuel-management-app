<?php

namespace App\Console;

use App\Models\FuelRequest;
use App\Models\FuelToken;
use App\Models\ScheduleDistribution;
use App\Models\Vehicle;
use App\Models\VehicleRegistration;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            //Renew Fuel For All Vehicles
            $get_vehicle_registration_count = VehicleRegistration::count();

            if($get_vehicle_registration_count > 0){
                $get_vehicle_registrations = VehicleRegistration::get();
                foreach ($get_vehicle_registrations as $key => $registrations) {
                    //Get total quota for vehicle
                    $standard_quota = 0;
                    $get_vehicle_detail_count = Vehicle::where('id', $registrations->vehicle_id)->count();
                    if($get_vehicle_detail_count > 0){
                        $get_vehicle_detail = Vehicle::where('id', $registrations->vehicle_id)->first();
                        $standard_quota = $get_vehicle_detail->standard_quota;
                    }

                    //Update and renew vehicle quota
                    $update_single_vehicle = VehicleRegistration::where('id', $registrations->id)->first();
                    $update_single_vehicle->available_quota = $standard_quota;
                    $update_single_vehicle->save();
                }

            }

        })->weeklyOn(1, '00:00');


        $schedule->call(function () {

           //Mark as expire all requests if passed 3 hours from scheduled date time
            $get_fuel_requests_count = FuelRequest::where('status', 2)->orWhere('status', 5)->count();

            if($get_fuel_requests_count > 0){
                $get_fuel_requests = FuelRequest::where('status', 2)->orWhere('status', 5)->get();

                foreach ($get_fuel_requests as $key => $fuel_request) {
                    //Confirmed Request
                    if($fuel_request->status == 2){
                
                        $current_date = Carbon::now();
                    
                        $to = Carbon::createFromFormat('Y-m-d H:s:i', $fuel_request->expected_date_time, '+0530');
                        $from = Carbon::createFromFormat('Y-m-d H:s:i', $current_date, '+0530');
            
                        $diff_in_hours = $to->diffInHours($from);

                        //3 hours passed
                        if($diff_in_hours > 3){
                            //Change fuel request and token status
                            $update_fuel_request_status = FuelRequest::where('id', $fuel_request->id)->first();
                            $update_fuel_request_status->status = 7;
                            $update_fuel_request_status->save();

                            $update_token_status_count = FuelToken::where('fuel_request_id', $fuel_request->id)->count();
                            if($update_token_status_count > 0){
                                $update_token_status = FuelToken::where('fuel_request_id', $fuel_request->id)->first();
                                $update_token_status->status = 4;
                                $update_token_status->save();
                            }


                        }

                    

                    }else{
                        //Rescheduled Request
                        if($fuel_request->status == 5){

                            $current_date = Carbon::now();
                    
                            $to = Carbon::createFromFormat('Y-m-d H:s:i', $fuel_request->rescheduled_date_time, '+0530');
                            $from = Carbon::createFromFormat('Y-m-d H:s:i', $current_date, '+0530');
                
                            $diff_in_hours = $to->diffInHours($from);
        
                            //3 hours passed
                            if($diff_in_hours > 3){
                                //Change fuel request and token status
                                $update_fuel_request_status = FuelRequest::where('id', $fuel_request->id)->first();
                                $update_fuel_request_status->status = 7;
                                $update_fuel_request_status->save();
        
                                $update_token_status_count = FuelToken::where('fuel_request_id', $fuel_request->id)->count();
                                if($update_token_status_count > 0){
                                    $update_token_status = FuelToken::where('fuel_request_id', $fuel_request->id)->first();
                                    $update_token_status->status = 4;
                                    $update_token_status->save();
                                }
        
        
                            }

                        } 
                    }
                }
            }

        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
