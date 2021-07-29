<?php
/**
 * Company created Listener
 *
 * PHP version 7.4
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
namespace App\Listeners;

use App\Events\CompanyCreatedEvent;
use App\Models\RealState;
use App\Models\Team;
use App\Models\User;
use App\Notifications\CompanyCreated;
use App\Notifications\CompanyCreatedAdmin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

/**
 *  Company created listener class
 *
 * @category MyCategory
 * @package  MyPackage
 * @author   Stefan Monteiro <stefanmonteiro@gmail.com>
 * @license  MIT treino.localhost
 * @link     link()
 * */
class CompanyCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event Event
     *
     * @return void
     */
    public function handle(CompanyCreatedEvent $event)
    {
        $super_admin = User::whereRoleIs('superadministrator')->get();
        $team = Team::where('name', $event->company->id)->first();
        $admin = User::whereRoleIs('administrator', $team)->get();
        $company = RealState::find($event->company->id);
        Notification::send(
            $super_admin, new CompanyCreatedAdmin($company)
        );
        Notification::send($admin, new CompanyCreated($company));

    }
}
