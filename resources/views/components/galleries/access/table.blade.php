@php
    use App\Models\User;
@endphp

<div class="py-4">
    <table>
        <caption>Accesses</caption>
        <thead>
            <tr>
                <th scope="col">User ID</th>
                <th scope="col">User Name</th>
                <th scope="col">User Email</th>
                <th scope="col">Action Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accesses as $access)
                <tr>
                    <td>{{ $access->user_id }}</td>
                    <td>{{ User::find($access->user_id)->name }}</td>
                    <td>{{ User::find($access->user_id)->email }}</td>
                    <td>
                        <x-galleries.access.delete :access="$access" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
