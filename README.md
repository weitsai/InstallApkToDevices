InstallApkToDevices
===================

本專案目的是把 apk 安裝多個已連接裝置上


環境設定
=========
1. 安裝 Android SDK，並把 `adb` 設為環境變數
2. 安裝 php 版本 4 以上，並設為環境變數，可用 `php -v` 查看版本
3. 將 `AXMLPrinter2.jar` 和 `Android2ApkDevices.php` 放置同一個目錄

使用方式
========
`php Android2ApkDevices.php [APK路徑]`

參考範例
`php Android2ApkDevices.php ~/IHelpActivity.apk`



程式運作原理
============
1. `adb devices` 取所有裝置編號
2. 利用 `AXMLPrinter2.jar` 取得 apk 的 `Package Name` and `Activity Name`
3. `adb -s [裝置編號] install [apk路徑]` 安裝 apk
4. `adb -s [裝置編號] shell am start -a android.intent.action.MAIN -n [Package Name]/[Acitivity Name]`





