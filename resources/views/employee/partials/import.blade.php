<div class=" col-auto float-right ml-auto" style="margin-bottom: 30px;">    
    <form action="{{ route('import.employees') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group w-auto">
            <input type="file" name="file" class="form-control" />
            <button type="submit" class="btn btn-primary add-btn" style="padding-bottom: 8px;"><i class="bi bi-plus-lg"></i>Import Employees</button>
        </div>
    </form>
</div>