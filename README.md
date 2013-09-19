InstallApkToDevices
===================

InstallApkToDevices 是解決一次要安裝某個 apk 到所有裝置上的問題，
因為 Android 碎片化問題嚴重，
當 layout 設計好後必須在許多裝置上看結果，
但是透過 eclipse 或是 android studio 都只能執行到某一支手機上，
因此本工具是要解決想要一次安裝到多個手機的使用者需求。


環境設定
=========
1. 安裝 jdk 並且把 `javac` 設為環境變數
2. 安裝 Android SDK，並把 `adb` 設為環境變數
3. 安裝 php 版本 5.3 以上，並設為環境變數，可用 `php -v` 查看版本
4. 將 `AXMLPrinter2.jar` 和 `InstallApkToDevices.php` 放置同一個目錄

使用方式
========
`php InstallApkToDevices.php [APK路徑]`

參考範例
`php InstallApkToDevices.php ~/IHelpActivity.apk`



程式運作原理
============
1. `adb devices` 取所有裝置編號
2. 透過解壓縮方式將 apk 內的 `AndroidManifest.xml` 取出
3. 利用 `AXMLPrinter2.jar` 還原 `AndroidManifest.xml` 內容，並取出 `Package Name` 及 `Activity Name`
4. `adb -s [裝置編號] install [apk路徑]` 安裝 apk
5. `adb -s [裝置編號] shell am start -a android.intent.action.MAIN -n [Package Name]/[Acitivity Name]`





