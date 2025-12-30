@extends('layouts.admin')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Analytics Overview</h1>
    </div>

    <div style="margin-bottom: 20px; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form action="{{ route('admin.analytics.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center;">
            <input type="text" name="search" placeholder="Search by title..." value="{{ request('search') }}" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
            
            <select name="status" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">All Status</option>
                <option value="now_showing" {{ request('status') == 'now_showing' ? 'selected' : '' }}>Now Showing</option>
                <option value="coming_soon" {{ request('status') == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <select name="sort_viewers" style="padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="desc" {{ request('sort_viewers') == 'desc' ? 'selected' : '' }}>Most Viewers</option>
                <option value="asc" {{ request('sort_viewers') == 'asc' ? 'selected' : '' }}>Least Viewers</option>
            </select>

            <button type="submit" style="padding: 8px 15px; background: #3182ce; color: white; border: none; border-radius: 4px; cursor: pointer;">Filter</button>
            <a href="{{ route('admin.analytics.index') }}" style="padding: 8px 15px; background: #cbd5e0; color: #2d3748; text-decoration: none; border-radius: 4px;">Reset</a>
        </form>
    </div>

    <!-- Summary Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #2b6cb0;">
            <div style="color: #666; font-size: 0.9rem; margin-bottom: 5px;">Total Movies</div>
            <div style="font-size: 1.8rem; font-weight: bold;">{{ $analytics->count() }}</div>
        </div>
        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #38a169;">
            <div style="color: #666; font-size: 0.9rem; margin-bottom: 5px;">Total Viewers</div>
            <div style="font-size: 1.8rem; font-weight: bold;">{{ $analytics->sum('total_viewers') }}</div>
        </div>
    </div>

    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #333;">Viewer Counts by Movie</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #f9f9f9; border-bottom: 2px solid #eee;">
                    <th style="padding: 15px;">Movie</th>
                    <th style="padding: 15px;">Status</th>
                    <th style="padding: 15px; text-align: right;">Total Viewers</th>
                </tr>
            </thead>
            <tbody>
                @foreach($analytics as $item)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px; font-weight: 500; display: flex; align-items: center; gap: 15px;">
                            <img src="{{ Str::startsWith($item['poster'], 'http') ? $item['poster'] : asset('storage/' . $item['poster']) }}" 
                                 style="width: 40px; height: 60px; object-fit: cover; border-radius: 4px; background: #eee;">
                            {{ $item['title'] }}
                        </td>
                        <td style="padding: 15px;">
                            @if($item['status'] == 'now_showing')
                                <span style="background: #e6fffa; color: #2c7a7b; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem;">Now Showing</span>
                            @elseif($item['status'] == 'coming_soon')
                                <span style="background: #fffaf0; color: #c05621; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem;">Coming Soon</span>
                            @else
                                <span style="background: #edf2f7; color: #4a5568; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 15px; text-align: right; font-weight: bold; font-size: 1.1rem; color: #2d3748;">
                            {{ number_format($item['total_viewers']) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
