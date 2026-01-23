@extends('home.partial.layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <div class="row align-items-center">

            <div class="col">
                <div class="pagetitle">
                    <h1>Leave Approval Flow</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item">Masters</li>
                            <li class="breadcrumb-item active">Leave Approval Flow</li>
                        </ol>
                    </nav>
                </div>
            </div>
           
        </div>
    </div> 
    <!-- /Page Header -->
    
    <div class="row">

            <h4 class="mb-3">Update Flow</h4>

            <form method="POST" action="{{ route('approval-flows.update',$flow->id) }}">
                @csrf
                @method('PUT')
        
                <div class="mb-3 col-md-6">
                    <label class="form-label">Flow Name</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ $flow->name }}" required>
                </div>
                
                <div class="mb-3 col-md-6">
                    <label class="form-label">Department</label>
                    <select name="department" class="form-select" required>
                        <option value="0" {{ 0 == $flow->department_id ? 'selected' : '' }}>All</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}"
                            {{ $flow->department_id == $department->id ? 'selected' : '' }} >
                                    {{ $department->name }}
                                </option>
                        @endforeach
                    </select>
                </div>
        
                <hr>
                <div class="mb-3 col-md-12">
                    <h6>Approval Hierarchy</h6>
            
                    <div id="approvalSteps">
                        @foreach($flow->steps as $index => $step)
                        <div class="row mb-2 step-row">
                            <div class="col-md-6">
                                <select name="steps[]" class="form-select" required>
                                    <option value="">Select Role</option>
                        
                                    @foreach($roles as $key => $role)
                                        <option value="{{ $key }}"
                                            {{ $step->role === $key ? 'selected' : '' }}>
                        
                                            @if($key === 'Vp')
                                                Executive Manager
                                            @elseif($key === 'Principal')
                                                Manager
                                            @else
                                                {{ $role }}
                                            @endif
                        
                                        </option>
                                    @endforeach
                        
                                </select>
                            </div>
                        
                            <div class="col-md-2">
                                <button type="button"
                                    class="btn btn-danger removeStep {{ $index === 0 ? 'd-none' : '' }}">
                                    X
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
        
                    <button type="button" class="btn btn-info mb-3" id="addStep">
                        + Add Step
                    </button>
            
                    <br>
            
                    <button type="submit" class="btn btn-success">
                        Update Flow
                    </button>
            
                    <a href="{{ route('approval-flows.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const addBtn = document.getElementById('addStep');
    const stepsContainer = document.getElementById('approvalSteps');

    addBtn.addEventListener('click', function () {
        let firstRow = stepsContainer.querySelector('.step-row');
        let clone = firstRow.cloneNode(true);

        clone.querySelector('select').value = '';
        clone.querySelector('.removeStep').classList.remove('d-none');

        stepsContainer.appendChild(clone);
    });

    document.addEventListener('click', function(e){
        if(e.target.classList.contains('removeStep')){
            e.target.closest('.step-row').remove();
        }
    });

});
</script>

@endsection