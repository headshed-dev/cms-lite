<div>
    @if($currentUserHasRoles)
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            <strong class="font-bold">Welcome!</strong>
            <span class="block sm:inline">You have roles assigned.</span>
            Go to the
            <a href="/admin" class="underline">Admin Panel</a>
        </div>
    @else
        <div class="relative px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
            <strong class="font-bold">Warning!</strong>
            <span class="block sm:inline">You have no roles assigned.</span>
            Please contact the administrator.
        </div>
    @endif
</div>
