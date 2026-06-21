<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>

        body{
            font-family: DejaVu Sans;
            font-size:12px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table,
        th,
        td{
            border:1px solid black;
        }

        th,
        td{
            padding:8px;
        }

        th{
            background:#f2f2f2;
        }

    </style>

</head>

<body>

    <h2>Branch Report</h2>

    <p>
        <strong>Total Branch :</strong>
        {{ $totalBranches }}
    </p>

    <p>
        <strong>Total Manager :</strong>
        {{ $totalManagers }}
    </p>

    <br>

    <table>

        <thead>

            <tr>

                <th>No</th>

                <th>Branch</th>

                <th>City</th>

                <th>Address</th>

                <th>Phone</th>

                <th>Manager</th>

            </tr>

        </thead>

        <tbody>

            @foreach($branches as $branch)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $branch->name }}</td>

                    <td>{{ $branch->city }}</td>

                    <td>{{ $branch->address }}</td>

                    <td>{{ $branch->phone }}</td>

                    <td>{{ $branch->manager?->name ?? '-' }}</td>

                </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>
