<div class="tab-pane" id="categorymessage">
    <form class="col-md-offset-1 col-sm-10" style="border-width: 4px 4px 4px 4px; padding :1em; background-color:white;" id="messagesForm" action="/send-categorized-message" method="get">
        @csrf
        <div class="panel-heading text-center">
            <h4></h4>
            <hr>
        </div>
        @include('layouts.message')
        <div class="form-group row md-form">
            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Categories</label>
            <div class="col-sm-10">
                <div class="btn-group">
                    <a href="#" class="btn btn-default dropdown-toggle w-50" data-toggle="dropdown">
                    Select a category &nbsp;<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" style="padding: 5px;" id="myDiv">
                        @foreach($categories as $category)
                        <div class="checkbox">
                            <label>
                            <input type="radio" name="category" value="{{$category->id}}" data-count="{{ $category->number_of_contacts }}" /> {{ $category->title }}
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
                <input type="text" class="form-control" id="datetimepicker1" name="scheduled_date" value="{{ old('created_at') }}" autocomplete="off"/>
            </div>
        </div>
        <div class="form-group row">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg">Text message</label>
            <div class="col-sm-8">
                <textarea type="text" class="form-control form-control-lg" rows="7" name="message" id="textBoxId" maxlength='310' value="{{ old('message') }}" required></textarea>
                <p id="numberOfChars">0   characters [1message is 160 characters,2messages 310 characters]</p>
                <br>
            </div>
        </div>
        {{-- <div class="form-group row">
            <label for="colFormLabelLg" class="col-sm-2 col-form-label col-form-label-lg"> Number of Contacts</label>
            <div class="col-sm-8">
                <input type="text" class="form-control form-control-lg" name="contact_character" id="contact_character" placeholder="">
            </div>
        </div> --}}
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