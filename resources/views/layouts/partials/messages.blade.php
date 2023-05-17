@if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        <ul style="list-style-type:none" class="alert alert-success">
            <button class="alert-success" style="float:right; border:none; box-shadow:none" onclick="this.parentElement.remove();"><i class="fa fa-x fa-sm"></i></button>
            @foreach ($data as $msg)
            <li>
                <i class="fa fa-check"></i>
                {{ $msg }}
            </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-success">
            <button class="alert-success" style="float:right; border:none; box-shadow:none" onclick="this.parentElement.remove();"><i class="fa fa-x fa-sm"></i></button>
            <i class="fa fa-check"></i>
            {{ $data }}
        </div>
    @endif
@endif

@if(Session::get('error', false))
    <?php $data = Session::get('error'); ?>
    @if (is_array($data))
        <ul style="list-style-type:none" class="alert alert-danger">
            <button class="alert-danger" style="float:right; border:none; box-shadow:none" onclick="this.parentElement.remove();"><i class="fa fa-x fa-sm"></i></button>
            @foreach ($data as $msg)
            <li>
                <i class="fa fa-x"></i>
                {{ $msg }}
            </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-danger" >
            <button class="alert-danger" style="float:right; border:none; box-shadow:none" onclick="this.parentElement.remove();"><i class="fa fa-x fa-sm"></i></button>
            <i class="fa fa-x"></i>
            {{ $data }}
        </div>
    @endif
@endif