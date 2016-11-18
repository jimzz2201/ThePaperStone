<form id="frmpaymentmethod">
    <div class="checkout-content" style="display: block;"><p>Please select the preferred payment method to use on this order.</p>
        <table class="radiotext">
            <tbody><tr class="highlight">
                    <td>            <input type="radio" name="payment_method" value="pp_express" id="pp_express" checked="checked">
                    </td>
                    <td>
                        <label for="pp_express">PayPal Express Checkout</label></td>
                </tr>

            </tbody></table>
        <br>
        <b>Add Comments About Your Order</b>
        <textarea name="comment_payment" rows="8" style="width: 98%;"></textarea>
        <br>
        <br>
        <div class="buttons">
            <div class="right">
                <input type="button" value="Continue" id="button-payment-method" class="button">
            </div>
        </div>
    </div>
</form>
<script>
    $("#button-payment-method").click(function () {
        if ($("[name='payment_method']:checked").length)
        {


            $.ajax(
                    {
                        url: baseurl + "/index.php/cart/CheckoutView",
                        data: $("#frmbillingdetails ,#frmdeliverydetails,#frmdeliverymethod,#frmpaymentmethod").serialize() + "&" + $.param({'isusenewaddress': isusenewaddress, 'isusenewdelivery': isusenewdelivery}),
                        dataType: "json",
                        type: "post",
                        success: function (data)
                        {
                            if (data.st)
                            {
                                checkoutstepnum = 6;
                                checkoutstep();
                                $("#step6 .checkout-content").html(data.view);

                            }
                            else
                            {
                                messageerror(data.msg);
                            }
                        },
                        error: function (xhr, status, error)
                        {

                            messageerror(xhr.responseText);
                        }
                    });

        }
        else
        {
            messageerror("No Payment Metod Selected");
        }


    })
</script> 