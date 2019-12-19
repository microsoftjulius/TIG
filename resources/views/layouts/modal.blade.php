<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/sign-agreement" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <input type="hidden" name="customer_id" id="customer_id">
                        <div class="col-lg-4">
                            <label for="defaulters-name">Name</label>
                            <input type="text" class="form-control" name="defaulter_name" id="customer_names" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="customer-refno">Customer RefNo</label>
                            <input type="text" class="form-control" name="customer_reference_number" id="customer-refNo" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="property-ref">Property RefNo</label>
                            <input type="text" name="property_number" id="property-ref" class="form-control" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="phone-number">Phone Number</label>
                            <input type="text" name="phone_number" id="phone-number" class="form-control" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="profession">Profession</label>
                            <input type="text" name="profession" id="profession" class="form-control" readonly>
                        </div>
                        <div class="col-lg-4">
                            <label for="comments">Comments</label>
                            <select name="comment" id="comment" class="form-control" required>
                                <option value=""></option>
                            @foreach ($reasons as $comment)
                                <option value={{ $comment->id}}>{{ $comment->comment }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="Arreas-in-amount">Arrears</label>
                            <input type="text" name="arreas_in_amount" id="Arreas-in-amount" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="reconnection-fee">Reconnection fee</label>
                            <input type="text" name="reconnection_fee" id="reconnection-fee" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="penalties">Penalties</label>
                            <input type="text" name="penalties" id="penalties" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="immediate-pay">Amount Paid Immediately</label>
                            <input type="text" name="amount_paid_immediatly" id="penalties" class="form-control">
                        </div>
                        {{--  <div class="col-lg-4">
                            <label for="monthly-installment">A monthly installment of</label>
                            <input type="text" name="monthly_installment" id="penalties" class="form-control">
                        </div>  --}}
                        <div class="col-lg-4">
                            <label for="daily-installment">To be paid in (months)</label>
                            <input type="text" name="to_be_paid_in" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-11" style="padding-top:20px">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Sign Agreement</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--send Message to Family-->
