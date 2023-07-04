<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <script
        src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}">
    </script>

    <div id="paypal-button-container"></div>
    <script>
        paypal.Buttons({
            createOrder() {
                return fetch("/api/orders", {
                        method: "POST",
                        headers: {
                            "Accept": 'application/json',
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            planId: "R7"
                        })
                    })
                    .then((res) => res.json())
                    .then((data) => data.data.id)
            },
            onApprove(data) {
                return fetch("/api/orders/capture", {
                        method: "post",
                        headers: {
                            "Accept": 'application/json',
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify({
                            orderId: data.orderID
                        })
                    })
                    .then((res) => res.json())
                    .then((data) => {
                        alert("Transaction Completed");
                    })

            },
            onCancel(data) {
                console.log("Transaction Cancelled", data);
            },
            onError(err) {
                console.log("Transaction Error", err);
            }
        }).render('#paypal-button-container');
    </script>
</body>

</html>
