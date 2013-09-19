<?php

$devices = explode("\n", shell_exec("adb devices"));
$pattern = "/([a-zA-Z0-9]+)\s+device/";
$zip = new ZipArchive;
if ($zip->open($argv[1]) === TRUE) {
  $zip->extractTo('.', 'AndroidManifest.xml');
  $zip->close();
}

$path = preg_replace("/([\w]*)InstallApkToDevices.php$/", '$1',$argv[0]);
$AndroidManifest = shell_exec("java -jar {$path}/AXMLPrinter2.jar AndroidManifest.xml");
$AndroidManifest = simplexml_load_string($AndroidManifest);
$package = $AndroidManifest->attributes()->package;


foreach ($AndroidManifest->application->activity as $activity) {
  $category = $activity->{'intent-filter'}->category;
  if ($category && $category->attributes('android', true)->name == 'android.intent.category.LAUNCHER') {
      $className = $activity->attributes('android', true)->name;
      break;
    }
}

for ($i = 1; $i < count($devices); $i++) {
  if (preg_match("/device$/", $devices[$i])) {
    // 裝置編號
    $deviceNum = preg_replace($pattern, "$1", $devices[$i]);
    echo "----------" . $deviceNum . "----------\n";
    // 安裝 apk 到指定手機
    echo shell_exec("adb -s $deviceNum install -r $argv[1]");
    // 在特定手機上執行特定程式
    $adbStartAppShell = "adb -s $deviceNum shell am start -a android.intent.action.MAIN -n $package/$className";
    echo shell_exec("$adbStartAppShell");
  }
}

shell_exec('rm AndroidManifest.xml');
