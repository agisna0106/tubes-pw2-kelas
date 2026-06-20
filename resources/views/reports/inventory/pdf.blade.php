<h2>Inventory Report</h2>

<table border="1" width="100%" cellpadding="5">

    <thead>
        <tr>
            <th>Date</th>
            <th>Product</th>
            <th>Type</th>
            <th>Qty</th>
            <th>User</th>
        </tr>
    </thead>

    <tbody>

    @foreach($movements as $movement)

        <tr>

            <td>
                {{ $movement->created_at }}
            </td>

            <td>
                {{ $movement->product->name }}
            </td>

            <td>
                {{ $movement->type }}
            </td>

            <td>
                {{ $movement->quantity }}
            </td>

            <td>
                {{ $movement->user->name }}
            </td>

        </tr>

    @endforeach

    </tbody>

</table>
