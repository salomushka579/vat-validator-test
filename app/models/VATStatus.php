<?php

enum VATStatus: string
{
    case VALID = 'valid';
    case CORRECTED = 'corrected';
    case INVALID = 'invalid';
}
