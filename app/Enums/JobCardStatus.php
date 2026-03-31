<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum JobCardStatus: string implements HasColor, HasLabel
{
    case Pending = 'pending';
    case Inspected = 'inspected';
    case AwaitingApproval = 'awaiting_approval';
    case InProgress = 'in_progress';
    case AwaitingParts = 'awaiting_parts';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Closed = 'closed';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Inspected => 'Inspected',
            self::AwaitingApproval => 'Awaiting Approval',
            self::InProgress => 'In Progress',
            self::AwaitingParts => 'Awaiting Parts',
            self::Completed => 'Completed',
            self::Cancelled => 'Cancelled',
            self::Closed => 'Closed / Paid',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::Pending => 'The vehicle has been received and is queued for initial assessment.',
            self::Inspected => 'A technician has performed a diagnostic and identified required repairs.',
            self::AwaitingApproval => 'The quotation has been sent; waiting for customer authorization to proceed.',
            self::InProgress => 'Active mechanical or electrical work is currently being performed.',
            self::AwaitingParts => 'Work is paused pending the arrival of required spare parts from suppliers.',
            self::Completed => 'All repairs are finished. The vehicle has passed quality checks and is ready for pickup.',
            self::Cancelled => 'The job was terminated before completion, usually by customer request.',
            self::Closed => 'Payment has been processed, and the vehicle has been released to the owner.',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Inspected => 'info',
            self::AwaitingApproval => 'warning',
            self::InProgress => 'info',
            self::AwaitingParts => 'warning',
            self::Completed => 'info',
            self::Cancelled => 'danger',
            self::Closed => 'success',
        };
    }
}
