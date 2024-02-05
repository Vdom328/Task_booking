<div class="col-12 d-flex justify-content-between mb-3 form-dish">
    <div class="col-md-5 col-8">
        <select class="form-select dish">
            <option value=""></option>
            @foreach ($data as $item)
                <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 col-4 d-flex justify-content-between">
        <div class="col-md-4 col-10">
            <input type="number" class="form-control col-2 quantity_dish" value="1" min="1">
        </div>
        <button type="button" class="btn btn-outline-danger rounded-circle close-button"><i class="fa fa-close"></i>
        </button>
    </div>
</div>
