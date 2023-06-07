@if(Session::get('success', false) || Session::get('error', false))
        <?php 
            if(Session::get('success', false)){
            $data = Session::get('success'); 
            $style = 'success';
            $bullet = 'check';
            }
            elseif(Session::get('error', false)){
                $data = Session::get('error'); 
                $style = 'danger';
                $bullet = 'x';
            }
        ?>
    
    <div class="alert alert-{{$style}}">
        <button class="alert-{{$style}}" style="float:right; border:none; box-shadow:none; height:24px;" onclick="this.parentElement.remove();"><i class="fa fa-x fa-sm"></i></button>
        @if (is_array($data))
                <ul style="list-style-type:none" class="m-0 p-0">
                    @foreach ($data as $msg)
                    <li>
                        <i class="fa fa-{{$bullet}}"></i>
                        {{ $msg }}
                    </li>
                    @endforeach
                </ul>
        @else
            <i class="fa fa-{{$bullet}}"></i>
            {{ $data }}
        @endif
    </div>

@endif