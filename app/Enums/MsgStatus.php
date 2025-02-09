<?php

namespace App\Enums;
enum MsgStatus: string
{
	case ACTIVE = 'active';
	case HIDDEN = 'hidden';
	case BLOCKED = 'blocked';
	case REVIEW = 'review';

}
