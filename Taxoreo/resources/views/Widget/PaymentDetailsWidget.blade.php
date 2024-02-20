@if(count($payment_details))
<div class="card">
    <div class="card-header p-1 bg-primary">
        <h4 class="text-white pl-2 pt-1">Payment Details</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table border">
                <thead class="thead-light">
                    <th class="p-1">Sr</th>
                    <th class="p-1">Payment Type</th>
                    <th class="p-1">Payable Amt</th>
                    <th class="p-1">Paid Amt</th>
                    <th class="p-1">Trans Id</th>
                    <th class="p-1">Trans At</th>
                </thead>
                <tbody class="list">
                @foreach($payment_details as $p)
                    <tr>
                        <td class="p-1">{{$loop->iteration}}</td>
                        <td class="p-1">{{$p->payment_type}}</td>
                        <td class="p-1">{{$p->payable_amount}}</td>
                        <td class="p-1">{{$p->paid_amount}}</td>
                        <td class="p-1">{{$p->transaction_id}}</td>
                        <td class="p-1">{{$p->addedon}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
