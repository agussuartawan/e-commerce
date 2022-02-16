<div class="row">
    <div class="col text-center">
        @if ($user->avatar)
            <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $user->avatar) }}"
                alt="Foto profil">
        @else
            <img class="profile-user-img img-fluid img-circle" src="/img/null-avatar.png" alt="Foto profil">
        @endif
    </div>
    <h3 class="profile-username text-center">{{ $user->name }}</h3>

    <p class="text-muted text-center">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</p>
</div>
