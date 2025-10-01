<tr>
  <td>
    <select name="items[__INDEX__][service_id]" class="form-select service-select" required>
      <option value="">-- Select Product --</option>
      @foreach($services as $s)
        <option value="{{ $s->service_id }}" data-price="{{ $s->price ?? 0 }}">{{ $s->service_name }}</option>
      @endforeach
    </select>
  </td>
  <td style="width: 200px;">
    <div class="input-group">
      <span class="input-group-text">Rp</span>
      <input type="number" step="0.01" min="0" name="items[__INDEX__][price_at_order]" class="form-control price-input" required>
    </div>
  </td>
  <td class="text-end">
    <button type="button" class="btn btn-sm btn-danger remove-row">Remove</button>
  </td>
</tr>