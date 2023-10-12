@php
    $contacts = \App\Models\AgentContact::where(function($q) use ($user) {
        $q->where('contact_id', $user->id)->orWhere('agent_id', $user->id);
    })->orderBy('id', 'desc')->get();
    $contracts = \App\Models\Contract::all();
    $myContracts = count($contacts) ? \App\Models\AgencyContract::whereIn('contact_id', $contacts->pluck('id')->all())->get() : [];
@endphp

@include('parts.contact-management.add-contact', ['commonMethods' => $commonMethods, 'user' => $user, 'skills' => $skills])

@include('parts.contact-management.my-contacts', ['commonMethods' => $commonMethods, 'user' => $user, 'skills' => $skills, 'contracts' => $contracts, 'contacts' => $contacts, 'myContracts' => $myContracts])

@include('parts.contact-management.contact-requests', ['commonMethods' => $commonMethods, 'user' => $user])

@include('parts.contact-management.my-groups', ['commonMethods' => $commonMethods, 'user' => $user])
