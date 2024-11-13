<?php

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Database\BaseBuilder;

if (!function_exists('start_user_session')) {
    function start_user_session($session, $user)
    {
        $session->set([
            'USER_LOGGED_IN' => true,
            'USER_ID' => $user->id,
            'USER_NAME' => $user->name,
            'USER_EMAIL' => $user->email,
            'USER_AVTAR' => $user->avatar,
            'USER_DESIGNATION' => $user->designation,
        ]);
    }
}

if (!function_exists('update_user_session')) {
    function update_user_session($session, $user)
    {
        $session->set([
            'USER_NAME' => $user->name,
            'USER_EMAIL' => $user->email,
            'USER_DESIGNATION' => $user->designation,
            'USER_AVTAR' => $user->avatar,
        ]);
    }
}

if (!function_exists('get_user')) {
    function get_user($session, $name)
    {
        return $session->get($name);
    }
}

if (!function_exists('remove_user_session')) {
    function remove_user_session($session, $userId)
    {
        if (is_null($userId)) {
            delete_cookie('REMEMBER_ME');
            return redirect_to_route('admin/home');
        }

        $session->remove(['USER_LOGGED_IN', 'USER_ID', 'USER_NAME', 'USER_EMAIL', 'USER_DESIGNATION', 'USER_AVTAR']);

        $adminModel = new \App\Models\AdminModel();
        $adminModel->resetToken($userId);

        $session->regenerate();
    }
}

if (!function_exists('is_auth')) {
    function is_auth($session, $adminModel)
    {
        if (!$session->has('USER_LOGGED_IN') || !$session->get('USER_LOGGED_IN')) {
            return false;
        }

        $userId = $session->get('USER_ID');
        $row = $adminModel->getUserById($userId);

        return !is_null($row);
    }
}

if (!function_exists('is_suspended')) {
    function is_suspended($session, $adminModel)
    {
        $userId = $session->get('USER_ID');
        $row = $adminModel->getUserById($userId);

        return $row->status == 0;
    }
}

if (!function_exists('is_authenticated')) {
    function is_authenticated($session, $adminModel)
    {
        // print_r(is_auth($session, $adminModel));die;
        if (is_auth($session, $adminModel)) {
            // echo "<pre>";
            return redirect_to_route('admin/home');
        } else {

            $token = get_cookie_value('REMEMBER_ME');
            if (!is_null($token)) {
                $row = $adminModel->getUserByToken($token);
                if (!is_null($row)) {
                    start_user_session($session, $row);
                    return  redirect_to_route('admin/home');
                }
            }
        }
    }
}

if (!function_exists('get_image')) {
    function get_image($path = '', $type = '')
    {
        if ($path != '' && file_exists($path)) {
            return base_url($path);
        } else {
            switch ($type) {
                case 'PROFILE':
                    return base_url('public/admin-assets/images/fallback/user.png');
                    break;
                default:
                    return base_url('public/admin-assets/images/fallback/image.png');
            }
        }
    }
}

if (!function_exists('user')) {
    function user($session, $adminModel)
    {
        $userId = $session->get('USER_ID');
        return $adminModel->getUserById($userId);
    }
}

if (!function_exists('upload_image')) {
    function upload_image($uploadName, $path)
    {
        $config = [];
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
        $config['max_size'] = 2048;

        $upload = \Config\Services::upload($config);

        if (!$upload->doUpload($uploadName)) {
            $error = $upload->getError();
            return ['status' => 0, 'error' => $error, 'path' => ''];
        } else {
            $data = $upload->getData();
            return ['status' => 1, 'error' => '', 'path' => $path . '/' . $data['file_name']];
        }
    }
}

if (!function_exists('remove_file')) {
    function remove_file($path)
    {
        if (!is_null($path) && trim($path) != '' && file_exists($path)) {
            unlink($path);
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('active_menu')) {
    function active_menu($request, $slug)
    {
        $segment = $request->uri->getSegment(2);
        return $segment == $slug ? 'active' : '';
    }
}

if (!function_exists('show_error_page')) {
    function show_error_page($httpCode)
    {
        switch ($httpCode) {
            case '404':
                echo "Page not found";
                break;
            default:
                echo "No code specified";
        }
    }
}

if (!function_exists('get_image_input')) {
    function get_image_input($inputName, $label, $required = false, $id = '', $imgPath = '#', $removeId = '', $fallbackType = '')
    {
        $id = $id != '' ? $id : get_random_string(6);
        $fallback = get_image('#');
        $img = get_image($imgPath, $fallbackType);

        $html = '<div class="row image-preview-wrap" id="' . $id . '">
            <div class="col-9 d-flex align-items-center">
                <div class="w-100">
                    <label for="" class="form-label">' . $label . '</label>';

        if ($required) {
            $html .= '<span class="text-danger required-mark">*</span>';
        }

        $html .= '</label>';

        $html .= '<input data-remove-id="' . $removeId . '" name="' . $inputName . '" class="form-control w-100" type="file" onchange="renderImagePreview($(this), \'#' . $id . '\')">
            <a onclick="removeRenderedImage($(this))" class="d-block text-end" href="javascript:void(0)">Remove</a>
            </div>
            </div>';

        $html .= '<div class="col-3 rounded bg-light"><img class="img-fluid rounded" data-fallback="' . $fallback . '" src="' . $img . '">
            </div>
        </div>';

        return $html;
    }
}

if (!function_exists('get_random_string')) {
    function get_random_string($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}

if (!function_exists('get_cookie_value')) {
    function get_cookie_value(string $cookieName)
    {
        helper('cookie');

        // Retrieve the value of the cookie
        return get_cookie($cookieName);
    }
}



if (!function_exists('redirect_to_route')) {
    function redirect_to_route(string $route)
    {
        helper('url');

        // Redirect to the specified route URL
        // echo base_url($route);die;
        // return redirect()->to(base_url($route));
        header("Location: " . base_url($route));
        exit;
    }
}
if (!function_exists('md5_password')) {
    /**
     * Hashes a password using MD5.
     *
     * @param string $password Plain text password
     * @return string Hashed password
     */
    function md5_password($password)
    {
        return md5($password);
    }
}

function getParentMenuList()
{
    // print_r(getData());die;
    $adminModel = new \App\Models\AdminModel();
    $session        = \Config\Services::session();
    $USER_ID = get_user($session, 'USER_ID');
    $parentMenuList = $adminModel->parentMenuList($USER_ID);
    // print_r($parentMenuList);die;
    return $parentMenuList;
}
function getchildMenuList($menu_id)
{
    $adminModel = new \App\Models\AdminModel();
    $session        = \Config\Services::session();
    $USER_ID = get_user($session, 'USER_ID');
    $childMenuList = $adminModel->childMenuList(1, $menu_id, $USER_ID);
    return $childMenuList;
}

function noRecShow($pageNoAr = array(2, 100, 500))
{
    foreach ($pageNoAr as $val) {
        echo '<option value="' . $val . '">' . $val . '</option>';
    }
}
if (!function_exists('where_string')) {
    function where_string(array $search, array $tableAliasAr = [], array $operator = [], array $colmnName = []): string
    {
        $whereAr = ['1=1'];

        $db = \Config\Database::connect();

        foreach ($search as $key => $fld) {
            $fld['name'] = trim($fld['name']);
            $fld['value'] = trim($fld['value']);

            if (in_array($fld['name'], ['list_type', 'list_id', 'pageNoH', 'recToShowH', 'orderByH', 'sortByH'])) {
                continue;
            }

            $tableAlias = '';

            if (isset($tableAliasAr[$fld['name']]) && $tableAliasAr[$fld['name']] !== '') {
                $tableAlias = $tableAliasAr[$fld['name']];
            } elseif (isset($tableAliasAr['*']) && $tableAliasAr['*'] !== '') {
                $tableAlias = $tableAliasAr['*'];
            }

            if ($fld['value'] === '') {
                unset($search[$key]);
            } else {
                // XSS cleaning
                $fld['name'] = filter_var($fld['name'], FILTER_SANITIZE_STRING);
                $fld['value'] = filter_var($fld['value'], FILTER_SANITIZE_STRING);

                $fldName = $colmnName[$fld['name']] ?? $fld['name'];

                if (isset($operator[$fld['name']])) {
                    switch ($operator[$fld['name']]) {
                        case 'LIKE':
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . " LIKE '%" . $fld['value'] . "%'";
                            break;
                        case 'LIKELEFT':
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . " LIKE '%" . $fld['value'] . "'";
                            break;
                        case 'LIKERIGHT':
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . " LIKE '" . $fld['value'] . "%'";
                            break;
                        case 'GT':
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . " > '" . $fld['value'] . "'";
                            break;
                        case 'LT':
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . " < '" . $fld['value'] . "'";
                            break;
                        case 'GTE':
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . " >= '" . $fld['value'] . "'";
                            break;
                        case 'LTE':
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . " <= '" . $fld['value'] . "'";
                            break;
                        case 'IN':
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . " IN (" . $fld['value'] . ")";
                            break;
                        case 'NOTIN':
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . " NOT IN (" . $fld['value'] . ")";
                            break;
                        case 'NOT':
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . " != '" . $fld['value'] . "'";
                            break;
                        case 'DLIKE':
                            $whereAr[] = "date(" . $db->escapeIdentifiers($tableAlias . $fldName) . ") LIKE '%" . $fld['value'] . "%'";
                            break;
                        case 'DLIKELEFT':
                            $whereAr[] = "date(" . $db->escapeIdentifiers($tableAlias . $fldName) . ") LIKE '%" . $fld['value'] . "'";
                            break;
                        case 'DLIKERIGHT':
                            $whereAr[] = "date(" . $db->escapeIdentifiers($tableAlias . $fldName) . ") LIKE '" . $fld['value'] . "%'";
                            break;
                        case 'DGT':
                            $whereAr[] = "date(" . $db->escapeIdentifiers($tableAlias . $fldName) . ") > '" . date("Y-m-d", strtotime($fld['value'])) . "'";
                            break;
                        case 'DLT':
                            $whereAr[] = "date(" . $db->escapeIdentifiers($tableAlias . $fldName) . ") < '" . date("Y-m-d", strtotime($fld['value']))  . "'";
                            break;
                        case 'DGTE':
                            $whereAr[] = "date(" . $db->escapeIdentifiers($tableAlias . $fldName) . ") >= '" . $fld['value'] . "'";
                            break;
                        case 'DLTE':
                            $whereAr[] = "date(" . $db->escapeIdentifiers($tableAlias . $fldName) . ") <= '" . $fld['value'] . "'";
                            break;
                        case 'DIN':
                            $whereAr[] = "date(" . $db->escapeIdentifiers($tableAlias . $fldName) . ") IN (" . $fld['value'] . ")";
                            break;
                        case 'DNOTIN':
                            $whereAr[] = "date(" . $db->escapeIdentifiers($tableAlias . $fldName) . ") NOT IN (" . $fld['value'] . ")";
                            break;
                        case 'DNOT':
                            $whereAr[] = "date(" . $db->escapeIdentifiers($tableAlias . $fldName) . ") != '" . $fld['value'] . "'";
                            break;
                        default:
                            $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . "='" . $fld['value'] . "'";
                            break;
                    }
                } else {
                    // Use query builder for automatic escaping
                    $whereAr[] = $db->escapeIdentifiers($tableAlias . $fldName) . "='" . $fld['value'] . "'";
                }
            }
        }

        return implode(' and ', $whereAr);
    }
}
if (!function_exists('tableList')) {
    function tableList(array $dataList, int $recCount, int $recToShow, int $pageNo, array $columns, string $id, bool $edit = false, bool $delete = false, array $htmlDataListStyle = [], string $onclickEdit = '', string $report = "", string $report_type = ""): void
    {
        // $right = getData();
        $colSpan = count($columns) + 2;

        if (!empty($dataList)) {
            $i = 1;
            foreach ($dataList as $data) {
?>
                <tr>
                    <?php if (1 == 1 || in_array(uri_string(), ['grade', 'packagingtype'])) : ?>
                        <td style="width:50px;" align="center"><?php echo $i + (($pageNo - 1) * $recToShow); ?></td>
                    <?php endif; ?>

                    <?php foreach ($columns as $columnDet) : ?>
                        <?php
                        $column = is_array($columnDet) && isset($columnDet['name']) ? $columnDet['name'] : $columnDet;
                        $align = is_array($columnDet) && isset($columnDet['align']) ? $columnDet['align'] : '';
                        ?>

                        <?php
                        $tagVal = '';
                        $linkValBefore = '';
                        $linkValAfter = '';
                        if (count($htmlDataListStyle) > 0 && isset($htmlDataListStyle["$column"]) && count($htmlDataListStyle["$column"]) > 0) {
                            if (isset($htmlDataListStyle["$column"]['tagString'])) {
                                $tagVal = $htmlDataListStyle["$column"]['tagString']['tagVal'];
                                if (isset($htmlDataListStyle["$column"]['tagString']['replaceColumn'])) {
                                    foreach ($htmlDataListStyle["$column"]['tagString']['replaceColumn'] as $tagArray) {
                                        $tagVal = str_replace("##$tagArray##", $data->$tagArray, $tagVal);
                                    }
                                }
                            }
                            if (isset($htmlDataListStyle["$column"]['linkString'])) {
                                $linkValBefore = $htmlDataListStyle["$column"]['linkString']['tagVal'];
                                if (isset($htmlDataListStyle["$column"]['linkString']['replaceColumn'])) {
                                    foreach ($htmlDataListStyle["$column"]['linkString']['replaceColumn'] as $tagArray) {
                                        $linkValBefore = str_replace("##$tagArray##", $data->$tagArray, $linkValBefore);
                                    }
                                }
                                $linkValAfter = $htmlDataListStyle["$column"]['linkString']['endString'];
                            }
                        }
                        ?>

                        <td class="<?= ($column == $report) ? (($data->$column < 0) ? 'border border-danger border-5 Pending' : 'border border-success border-5 Paid') : "" ?>" align="<?= !empty($align) ? $align : 'center' ?>">
                            <div class="datacolumn">
                                <?= $linkValBefore ?>
                                <?php if ($column == $id) {
                                    echo '#';
                                }
                                echo htmlspecialchars($data->$column);
                                ?>
                                <?= $linkValAfter ?>
                            </div>
                            <?= $tagVal ?>
                        </td>
                    <?php endforeach; ?>

                    <?php if ($id !== null) : ?>
                        <td style="white-space:nowrap; width:80px;" align="center">
                            <?php if ($edit) : ?>
                                <button class="btn cencel-file rounded-pill btn-icon btn-outline-primary btn-sm btn-floating me-1 <?= $edit ? '' : 'disabled' ?>" href="javascript:void(0);" onclick="<?= $onclickEdit ?>(<?= $data->$id ?>);"><i class="bx bx-edit-alt<?= $edit ? '' : ' disabled' ?> me-1"></i></button>
                            <?php endif; ?>

                            <?php if ($delete) : ?>
                                <button class="btn cencel-list_file rounded-pill me-1 btn-icon btn-outline-danger btn-sm btn-floating" href="javascript:void(0);" onclick="deleteRec(<?= $data->$id ?>)"><i class="bx bx-trash"></i></button>

                            <?php endif; ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php $i++; ?>
            <?php } ?>

            <tr id="paging">
                <td colspan="<?= $colSpan ?>" style="background:#fff">
                    <?= pagination($recCount, $recToShow, $pageNo) ?>
                </td>
            </tr>
        <?php } else { ?>
            <tr class="no_records_found">
                <td style="text-align:center;" colspan="<?= $colSpan ?>">No Records Found</td>
            </tr>
        <?php }
    }
}


function pagination($recCount, $recToShow, $pageNo, $pageShow = 2, $type = 'AJAX'): void
{
    $totalPage = ceil($recCount / $recToShow);
    $startPage = max(1, $pageNo - $pageShow);
    $endPage = min($pageNo + $pageShow, $totalPage);

    if ($startPage < $endPage) {
        ?>
        <ul class="pagination  pull-left btn-toolbar" role="toolbar" data-page="<?php echo $totalPage; ?>">
            <?php if ($pageNo != 1) : ?>
                <li class="page-item prev ">
                    <a href="javascript:void(0)" class="page-link" onClick="pagination('F','<?php echo $type; ?>',this)"><i class="tf-icon bx bx-chevrons-left"></i></a>
                </li>
                <li class="page-item prev">
                    <a href="javascript:void(0)" class="page-link" onClick="pagination('P','<?php echo $type; ?>',this)"><i class="tf-icon bx bx-chevron-left"></i></a>
                </li>
            <?php endif; ?>

            <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                <li class="page-item <?php echo ($pageNo == $i) ? 'active' : ''; ?>">
                    <a href="javascript:void(0)" class="page-link" onClick="pagination('<?php echo $i; ?>','<?php echo $type; ?>',this)"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($pageNo != $totalPage) : ?>
                <li class="page-item">
                    <a href="javascript:void(0)" class="page-link" onClick="pagination('N','<?php echo $type; ?>',this)"><i class="tf-icon bx bx-chevron-right"></i></a>
                </li>
                <li class="page-item">
                    <a href="javascript:void(0)" class="page-link" onClick="pagination('L','<?php echo $type; ?>',this)"><i class="tf-icon bx bx-chevrons-right"></i></a>
                </li>
            <?php endif; ?>
        </ul>
        <?php
    }
}

if (!function_exists('pr')) {
    function pr($ar, $ex = 0)
    {
        echo '<pre>';
        print_r($ar);
        echo '</pre>';
        if ($ex == 1) {
            exit;
        }
    }
}

if (!function_exists('selectList')) {
    function selectList($dataList, $value, $option, $selected = '')
    {
        foreach ($dataList as $data) { ?>
            <option value="<?php echo $data->$value; ?>" <?php if ($data->$value == $selected) {
                                                                echo ' selected';
                                                            } ?>><?php echo $data->$option; ?></option>
<?php
        }
    }
}

if (!function_exists('printLastQuery')) {
function printLastQuery()
{
    $db = \Config\Database::connect();
    echo $db->getLastQuery();
}
}
?>