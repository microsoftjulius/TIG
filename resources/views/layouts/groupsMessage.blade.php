<div class="tab-pane active" id="groupmessage">
    <form class="col-md-offset-1 col-sm-10" style="border-width: 4px 4px 4px 4px; padding :1em; background-color:white;" id="messagesForm" action="/store-sent-messages" method="get">
        @csrf
        <div class="panel-heading text-center">
            <h4></h4>
            <hr>
        </div>
        @include('layouts.message')
        <div class="form-group row md-form">
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Contact groups</label>
            <div class="col-sm-10">
                <div class="btn-group">
                    <a href="#" class="btn btn-default dropdown-toggle w-50" data-toggle="dropdown">
                    Select a group &nbsp;<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" style="padding: 5px;" id="myDiv">
                        <li><input type="checkbox" id="select_all"/> All groups</li>
                        @foreach($drop_down_groups as $picking_from_database)
                        <div class="checkbox1 checkbox">
                            <label>
                            <input type="checkbox" class="checkbox dropdown-item checkbox-primary" name="checkbox[]" value="{{$picking_from_database->id}}" data-count="{{ $picking_from_database->number_of_contacts }}" /> {{ $picking_from_database->group_name }}
                            </label>
                        </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div id="pageloader">
            <img src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />
        </div>
        <div class="form-group row">
            <label for="colFormLabel" class="col-sm-2 col-form-label">Date and time</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="datetimepicker" name="scheduled_date" value="{{ old('created_at') }}" autocomplete="off" />
            </div>
        </div>
        <div class="form-group row">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Text message</label>
            <div class="col-sm-8">
                <textarea type="text" class="form-control form-control-lg" rows="7" name="message" id="message" onkeyup="countChars(this);" maxlength='310' value="{{ old('message') }}" required></textarea>
                <p id="charNum">0   characters [1 message is 160 characters,2messages 310 characters]</p>
                <br>
            </div>
        </div>
        <div class="form-group row">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg"> Number of Contacts</label>
            <div class="col-sm-8">
                <input type="text" class="form-control form-control-lg" name="contact_character" id="contact_character" placeholder="">
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

