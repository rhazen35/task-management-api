<?php

declare(strict_types=1);

namespace App\Model\Task;

enum TaskStatus: string
{
    case Backlog = 'backlog';
    case ToDo = 'to-do';
    case InProgress = 'in-progress';
    case Feedback = 'feedback';
    case RequiresMeeting = 'requires-meeting';
    case Completed = 'completed';

    case BacklogTitle = 'Backlog';
    case ToDoTitle = 'ToDo';
    case InProgressTitle = 'In Progress';
    case FeedbackTitle = 'Feedback';
    case RequiresMeetingTitle = 'Requires Meeting';
    case CompletedTitle = 'Completed';

    /**
     * @return array<string>
     */
    public static function availableValues(): array
    {
        return [
            self::Backlog->value,
            self::ToDo->value,
            self::InProgress->value,
            self::Feedback->value,
            self::RequiresMeeting->value,
            self::Completed->value,
        ];
    }

    /**
     * @return array<TaskStatus>
     */
    public static function available(): array
    {
        return [
            self::Backlog,
            self::ToDo,
            self::InProgress,
            self::Feedback,
            self::RequiresMeeting,
            self::Completed,
        ];
    }
}
