<table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
    <thead>
        <tr>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f2f2f2;">Product</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: left; background-color: #f2f2f2;">License</th>
            <th style="border: 1px solid #ddd; padding: 12px; text-align: center; background-color: #f2f2f2;">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td style="border: 1px solid #ddd; padding: 12px;">
                    {{ $item->product->name }}
                </td>
                <td style="border: 1px solid #ddd; padding: 12px;">
                    {{ ucfirst($item->license_type) }} License
                    @if ($item->extended_support)
                        <br><small>(+ Extended Support)</small>
                    @endif
                </td>
                <td style="border: 1px solid #ddd; padding: 12px; text-align: center;">
                    <a href="{{ route('user.download', $item->id) }}"
                        style="background-color:#0d6efd;color:white;padding:6px 12px;text-decoration:none;border-radius:5px;display:inline-block;">
                        Download
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
