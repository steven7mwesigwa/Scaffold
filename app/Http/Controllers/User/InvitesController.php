<?php

namespace App\Http\Controllers\User;

use App\Models\Invite;
use App\Http\Controllers\Controller;
use App\Notifications\StandardEmail;
use Illuminate\Support\Facades\Notification;

class InvitesController extends Controller
{
    /**
     * Display a listing of invites.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invites = auth()->user()->invites;

        return view('user.invites.index')
            ->with('invites', $invites);
    }

    /**
     * Accept an invite
     *
     * @param \App\Models\Invite $invite
     * @return \Illuminate\Http\Response
     */
    public function accept(Invite $invite)
    {
        $relationship = $invite->relationship;
        auth()->user()->$relationship()->attach($invite->model_id);

        if ($invite->delete()) {
            return back()->with('message', 'Invitation accepted');
        }

        return back()->withErrors(['Unable to accept the inviation']);
    }

    /**
     * Reject an invite
     *
     * @param \App\Models\Invite $invite
     * @return \Illuminate\Http\Response
     */
    public function reject(Invite $invite)
    {
        $subject = "Invitation Rejected";
        $message = "{$invite->enail} politely rejected your inviation.";

        Notification::route('mail', $invite->from->email)
            ->notify(new StandardEmail(
                $invite->from->email,
                $subject,
                $message
            ));

        if ($invite->delete()) {
            return back()->with('message', 'Invitation rejected');
        }

        return back()->withErrors(['Unable to reject the inviation']);
    }
}
