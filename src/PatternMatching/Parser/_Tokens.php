<?php

/**
 * pattern matching grammar
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\PatternMatching\Parser;

/**
 * @var int PM_TRUE Boolean true value <true>
 */
const PM_TRUE             = 1;

/**
 * @var int PM_FALSE Boolean false value <false>
 */
const PM_FALSE            = 2;

/**
 * @var int PM_INTEGER Integer value <(\-?\d+)>
 */
const PM_INTEGER          = 3;

/**
 * @var int PM_FLOAT Floating point value <(\-?\d+(.\d+)?)>
 */
const PM_FLOAT            = 4;

/**
 * @var int PM_STRING String value <\"(\\\\.|[^\"])*\">
 */
const PM_STRING           = 5;

/**
 * @var int PM_WILDCARD Boolean true value <(\_)>
 */
const PM_WILDCARD         = 6;

/**
 * @var int PM_IDENTIFIER Placeholder value <.*>
 */
const PM_IDENTIFIER       = 7;

/**
 * @var int PM_TRUE Boolean true value <true>
 */
const PM_CONS             = 8;

/**
 * @var int PM_RULE_ARRAY Array parser
 */
const PM_RULE_ARRAY       = 100;

/**
 * @var int PM_RULE_CONS Cons parser
 */
const PM_RULE_CONS        = 101;

/**
 * @var int PM_RULE_WILDCARD Wildcard value parser
 */
const PM_RULE_WILDCARD    = 102;

/**
 * @var int PM_RULE_UNKNOWN Unknown value parser
 */
const PM_RULE_UNKNOWN     = 103;

/**
 * @var int PM_RULE_IDENTIFIER Identifier parser
 */
const PM_RULE_IDENTIFIER  = 104;

/**
 * @var int PM_RULE_STRING String value parser
 */
const PM_RULE_STRING      = 105;
