<p>Please select the preferred shipping method to use on this order.</p>
<form id="frmdeliverymethod">
<table class="radio" >
    <tbody>
        <tr>
            <td colspan="3"><b>Weight Based Shipping</b></td>
        </tr>
    <tbody>


    </tbody>
</tbody></table>
<br>
<b>Add Comments About Your Order</b>
<textarea name="comment" rows="8" style="width: 98%;"></textarea>
<br>
<br>
<div class="buttons">
    <div class="right">
        <input type="button" value="Continue" id="button-shipping-method" class="button">
    </div>
</div>
</form>
<script>
    $("#button-shipping-method").click(function () {
        if ($("[name='shipping_method']:checked").length)
        {

            checkoutstepnum = 5;
            checkoutstep();
        }
        else
        {
            messageerror("No Shipment Metod Selected");
        }


    })
</script>    