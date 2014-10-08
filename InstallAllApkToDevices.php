<?php
define('APKS_DIR_PATH', isset($argv[1]) ? $argv[1] : false);

if (!APKS_DIR_PATH) {
  echo 'error: 請輸入資料夾路徑!';
  exit;
}

$apks = glob(APKS_DIR_PATH . '/*.apk');
if (count($apks) <= 0) {
  echo '找不到任何一個 apk.';
  exit;
}

$path = preg_replace("/([\w]*)InstallAllApkToDevices.php$/", '$1',$argv[0]);

$isAutoInstall = false;
echo '是否一次安裝全部呢？[y/N]';
if (strtoupper(readline()) == 'Y') {
  $isAutoInstall = true;
}

foreach($apks as $apk) {
  if (!$isAutoInstall) {
    echo "是否要安裝 {$apk} 呢？[Y/n/q]";
    $userInput = strtoupper(readline());
    if ($userInput == "N") {
      continue;
    }

    if ($userInput == "Q") {
      break;
    }
  }

  echo shell_exec("php {$path}/InstallApkToDevices.php $apk");
}
