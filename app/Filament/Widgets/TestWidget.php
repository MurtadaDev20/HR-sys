<?php

namespace App\Filament\Widgets;

use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('عدد الموظفين', \App\Models\User::count())
                ->color('success')
                ->icon('heroicon-o-users')
                ->chart([
                    'datasets' => [
                        [
                            'label' => 'عدد الموظفين',
                            'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                        ],
                    ],
                    'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                ]),
            Stat::make('عدد الأقسام', \App\Models\Department::count())
                ->color('warning'),

            Stat::make('طلبات الإجازة (اليوم)', \App\Models\LeaveRequest::whereDate('created_at', now())->count())
                ->color('danger')
                ->icon('heroicon-o-calendar'),
            Stat::make('عدد الموظفين (اليوم)', \App\Models\User::whereDate('created_at', now())->count())
                ->color('primary'),
            Stat::make('عدد الموظفين (هذا الشهر)', \App\Models\User::whereMonth('created_at', now()->month)->count())
                ->color('primary'),
            Stat::make('عدد الموظفين (هذا العام)', \App\Models\User::whereYear('created_at', now()->year)->count())
                ->color('primary'),
            Stat::make('مجموع الرواتب', \App\Models\Payroll::sum('net_salary') . ' د.ع')
                ->color('success')
                ->icon('heroicon-o-currency-dollar')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before),
            Stat::make('عدد العقود', \App\Models\Contract::count())
                ->color('warning')
                ->icon('heroicon-o-document-text'),
            Stat::make('عدد سجلات الحضور', \App\Models\Attendance::count())
                ->color('info')
                ->icon('heroicon-o-clock'),
            Stat::make('عدد طلبات الإجازة', \App\Models\LeaveRequest::count()),
            Stat::make('عدد طلبات الإجازة المعلقة', \App\Models\LeaveRequest::where('status', 'pending')->count()),
            Stat::make('عدد طلبات الإجازة المقبولة', \App\Models\LeaveRequest::where('status', 'approved')->count()),
            Stat::make('عدد طلبات الإجازة المرفوضة', \App\Models\LeaveRequest::where('status', 'rejected')->count()),
        ];
    }
}
