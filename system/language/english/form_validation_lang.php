<?php

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') or exit('No direct script access allowed');

$lang['form_validation_required']        = 'Bidang {field} wajib diisi.';
$lang['form_validation_isset']            = 'Bidang {field} harus memiliki nilai.';
$lang['form_validation_valid_email']        = 'Bidang {field} harus berisi email yang valid.';
$lang['form_validation_valid_emails']        = 'Bidang {field} harus berisi semua alamat email yang valid.';
$lang['form_validation_valid_url']        = 'Bidang {field} harus berisi URL yang valid.';
$lang['form_validation_valid_ip']        = 'Bidang {field} harus berisi IP yang valid.';
$lang['form_validation_valid_base64']        = 'Bidang {field} harus berisi string Base64 yang valid.';
$lang['form_validation_min_length']        = 'Bidang {field} harus memiliki panjang minimal {param} karakter.';
$lang['form_validation_max_length']        = 'Bidang {field} tidak boleh melebihi {param} karakter.';
$lang['form_validation_exact_length']        = 'Bidang {field} harus tepat {param} karakter.';
$lang['form_validation_alpha']            = 'Bidang {field} hanya boleh berisi karakter alfabet.';
$lang['form_validation_alpha_numeric']        = 'Bidang {field} hanya boleh berisi karakter alfanumerik.';
$lang['form_validation_alpha_numeric_spaces']    = 'Bidang {field} hanya boleh berisi karakter alfanumerik dan spasi.';
$lang['form_validation_alpha_dash']        = 'Bidang {field} hanya boleh berisi karakter alfanumerik, garis bawah dan tanda hubung.';
$lang['form_validation_numeric']        = 'Bidang {field} hanya boleh berisi angka.';
$lang['form_validation_is_numeric']        = 'Bidang {field} hanya boleh berisi karakter numerik.';
$lang['form_validation_integer']        = 'Bidang {field} harus berisi bilangan bulat.';
$lang['form_validation_regex_match']        = 'Bidang {field} kolom tidak sesuai dengan format yang.';
$lang['form_validation_matches']        = 'Bidang {field} tidak cocok dengan bidang {param}.';
$lang['form_validation_differs']        = 'Bidang {field} harus berbeda dari bidang {param}.';
$lang['form_validation_is_unique']         = 'Bidang {field} harus berisi nilai unik.';
$lang['form_validation_is_natural']        = 'Bidang {field} kolom hanya boleh berisi angka.';
$lang['form_validation_is_natural_no_zero']    = 'Bidang {field} hanya boleh berisi angka dan lebih dari 0.';
$lang['form_validation_decimal']        = 'Bidang {field} hanya berisi angka desimal.';
$lang['form_validation_less_than']        = 'Bidang {field} harus berisi kurang dari {param}.';
$lang['form_validation_less_than_equal_to']    = '{field} bidang harus berisi angka yang kurang {param}.';
$lang['form_validation_greater_than']        = 'Bidang {field} harus berisi angka yang lebih besar dari {param}.';
$lang['form_validation_greater_than_equal_to']    = 'Bidang {field} harus berisi lebih besar atau sama dengan dari {param}.';
$lang['form_validation_error_message_not_set']    = 'Unable to access an error message corresponding to your field name {field}.';
$lang['form_validation_in_list']        = 'The {field} field must be one of: {param}.';


// $lang['form_validation_required']        = 'The {field} field is required.';
// $lang['form_validation_isset']            = 'The {field} field must have a value.';
// $lang['form_validation_valid_email']        = 'The {field} field must contain a valid email address.';
// $lang['form_validation_valid_emails']        = 'The {field} field must contain all valid email addresses.';
// $lang['form_validation_valid_url']        = 'The {field} field must contain a valid URL.';
// $lang['form_validation_valid_ip']        = 'The {field} field must contain a valid IP.';
// $lang['form_validation_valid_base64']        = 'The {field} field must contain a valid Base64 string.';
// $lang['form_validation_min_length']        = 'The {field} field must be at least {param} characters in length.';
// $lang['form_validation_max_length']        = 'The {field} field cannot exceed {param} characters in length.';
// $lang['form_validation_exact_length']        = 'The {field} field must be exactly {param} characters in length.';
// $lang['form_validation_alpha']            = 'The {field} field may only contain alphabetical characters.';
// $lang['form_validation_alpha_numeric']        = 'The {field} field may only contain alpha-numeric characters.';
// $lang['form_validation_alpha_numeric_spaces']    = 'The {field} field may only contain alpha-numeric characters and spaces.';
// $lang['form_validation_alpha_dash']        = 'The {field} field may only contain alpha-numeric characters, underscores, and dashes.';
// $lang['form_validation_numeric']        = 'The {field} field must contain only numbers.';
// $lang['form_validation_is_numeric']        = 'The {field} field must contain only numeric characters.';
// $lang['form_validation_integer']        = 'The {field} field must contain an integer.';
// $lang['form_validation_regex_match']        = 'The {field} field is not in the correct format.';
// $lang['form_validation_matches']        = 'The {field} field does not match the {param} field.';
// $lang['form_validation_differs']        = 'The {field} field must differ from the {param} field.';
// $lang['form_validation_is_unique']         = 'The {field} field must contain a unique value.';
// $lang['form_validation_is_natural']        = 'The {field} field must only contain digits.';
// $lang['form_validation_is_natural_no_zero']    = 'The {field} field must only contain digits and must be greater than zero.';
// $lang['form_validation_decimal']        = 'The {field} field must contain a decimal number.';
// $lang['form_validation_less_than']        = 'The {field} field must contain a number less than {param}.';
// $lang['form_validation_less_than_equal_to']    = 'The {field} field must contain a number less than or equal to {param}.';
// $lang['form_validation_greater_than']        = 'The {field} field must contain a number greater than {param}.';
// $lang['form_validation_greater_than_equal_to']    = 'The {field} field must contain a number greater than or equal to {param}.';
// $lang['form_validation_error_message_not_set']    = 'Unable to access an error message corresponding to your field name {field}.';
// $lang['form_validation_in_list']        = 'The {field} field must be one of: {param}.';
