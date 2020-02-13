<div class="tab-pane" id="nocategorymessage">
    <form class="col-md-offset-1 col-sm-10" style="border-width: 4px 4px 4px 4px; padding :1em; background-color:white;" id="messagesForm" action="/send-uncategorized-message" method="get">
        @csrf
        <div class="panel-heading text-center">
            <h4></h4>
            <hr>
        </div>
        @include('layouts.message')
        <div id="pageloader">
            <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />
        </div>
        <div class="form-group row">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Text message</label>
            <div class="col-sm-8">
                <textarea type="text" class="form-control form-control-lg" rows="7" name="message" id="textBoxIduncat" maxlength='310' value="{{ old('message') }}" required></textarea>
                <p id="numberOfCharsuncat">0   characters [1 message is 160 characters,2messages 310 characters]</p>
                <br>
            </div>
        </div>
        <div class="form-group row">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg"> Number of Contacts</label>
            <div class="col-sm-8">
                <input type="text" class="form-control form-control-lg" name="contact_character" id="category_contacts_count" placeholder="" value="{{auth()->user()->getCountOfUncategorized()}}"/>
            </div>
        </div>
        <div class="form-group row">
            <div class="text-center py-4 mt-3 ">
                <button type="submit" class="btn btn-primary">
                    <li class="fa fa-send-o"></li>
                    Send Message
                </button>
                <a href="{{url()->previous()}}"><button type="button" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</i></button></a>
            </div>
        </div>
    </form>
</div>