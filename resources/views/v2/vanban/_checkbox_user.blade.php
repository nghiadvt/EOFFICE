<style>
    .checkbox-group {
        margin-bottom: 5px;
    }
    .checkbox-l {
        font-weight: bold;
    }
    .checkbox-c {
        padding: 0 0 0 15px;
    }
    .checkbox-c label {
        font-weight: normal;
    }
    .checkbox-c input {
        margin-right: 5px;
    }
    .label-name {
        padding: 5px 0;
    }
</style>

@if (sizeof($data))
    @foreach ($data as $donviName => $users)
        <div class="checkbox-group">
            <div class="checkbox-l">
                <label><input type="checkbox" class="check-all"> <span> {{ $donviName }}</span></label>
            </div>
            <div class="checkbox-c">
                @foreach ($users as $user)
                    <div><label class="label-name"><input type="checkbox" value="{{ $user->id }}" name="{{ $checkboxName }}" {{ in_array($user->id, $selectedUserIds)? 'checked' : '' }}> <span>{{ $user->fullname.' - '.$user->chucdanh.' - '.$user->email }}</span></label></div>
                @endforeach
            </div>
        </div>
    @endforeach
@else
    Không có dữ liệu
@endif
<script>
    var checkboxGroups = document.querySelectorAll('.checkbox-group');
    
    for (var i = 0; i < checkboxGroups.length; i++) {
        var checkAll = checkboxGroups[i].querySelector('.check-all');
        var checkboxes = checkboxGroups[i].querySelectorAll('input[type=checkbox]:not(.check-all)');
        
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                var allChecked = true;
                for (var j = 0; j < checkboxes.length; j++) {
                    if (!checkboxes[j].checked) {
                        allChecked = false;
                        break;
                    }
                }
                checkAll.checked = allChecked;
            });
        });
        
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = checkAll.checked;
            });
        });
    }
</script>