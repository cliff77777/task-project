# 任務管理系統 (Task Management System)

## 專案說明

-   本專案是使用 Laravel 10 開發的任務管理系統，前端視圖未使用 Laravel 的 Blade 模板，而是由 ChatGPT 協作設計畫面布局。

-   使用技術:

    -   CSS、HTML、jQuery、Bootstrap 5、PHP 8、MySQL、Docker (基於 Ubuntu 20.04)、Apache、Git、ChatGPT

-   套件使用:
-   Yajra DataTables
-   Chart.js
-   Queue Database
-   Activity Log
-   Vite

## 使用者註冊流程

-   使用 Laravel 的 RegistersUsers 控制器處理註冊與權限驗證。

1. 使用者填入姓名、電子信箱、密碼、確認密碼來完成註冊，前端使用 HTML 的 required 屬性進行初步驗證，後端則透過 Laravel Validator 進行更深入的驗證。
2. 驗證通過後，後端會觸發 Laravel 的註冊事件並使用 SendEmailVerificationNotification 寄送信箱驗證信件。
3. 使用者點擊驗證信中的連結後，完成註冊並登入系統。
4. 如果使用者在登入時尚未完成信箱驗證，系統會顯示錯誤訊息並提供重新寄送驗證信的連結（見圖三）。
5. 驗證信箱後，使用者可以通過 Navbar 的 "Login" 進行登入（見圖四）。

-   圖一:
    ![image](https://github.com/user-attachments/assets/bc989880-c78b-4b24-9b01-0286863cbaf6)

-   圖二:
    ![image](https://github.com/user-attachments/assets/e982ef46-f2e4-4a2f-b8ec-bdce8fc53320)

-   圖三:
    ![image](https://github.com/user-attachments/assets/ea9783ed-0ab4-4942-8ecb-40d72d30d94d)

-   圖四:
   ![image](https://github.com/user-attachments/assets/cf325709-aad3-407a-9ca6-e57e8c94c5dd)

## 系統概述

-   本系統旨在記錄並管理任務工單的工作進展。當接收到新任務時，系統會透過電子郵件通知負責執行者，並在流程進行中通知下一位執行者。

-   任務流程可依據實際需求自訂，系統支持多層級的任務流程管理，並可追蹤任務的進度、經手人員及複雜度。

-   儀錶板將顯示任務數量、收到的任務數量，以及個人工作效率等資訊。

    -   任務案例: 假設公司內的電燈壞了，部門主管發現問題後，將其記錄在系統中，並指派維修人員進行修理。完成後，系統會通知另一位同事進行驗收，最後由主管進行最終確認並完成該任務。
        任務創建準備事項

1. 建立權限身份

-   進入側邊選單 (sidebar) 中的「使用者權限」頁面，並點選「新增權限」。
    ![image](https://github.com/user-attachments/assets/ea867dc2-282e-4bfe-8dec-56c40bc58a32)
-   輸入權限名稱和說明，即可完成權限創建。
    ![image](https://github.com/user-attachments/assets/f290f500-a3c5-41c4-9812-6206b31cd16a)
-   範例中包含部門經理、工程人員、驗收人員和部門人員四種權限。
    ![image](https://github.com/user-attachments/assets/53adf310-86da-42e2-ac69-44a605a1b100)

2. 建立使用者

-   在側邊選單中選擇「使用者管理」->「新增使用者」。
    ![image](https://github.com/user-attachments/assets/82b7e23d-b40f-47d8-9b00-cd4edecb2b41)
    ![image](https://github.com/user-attachments/assets/783c6cec-4442-4639-915c-94bd359cb787)
-   填入使用者資訊後提交，系統會提示驗證電子郵件。
-   ![image](https://github.com/user-attachments/assets/9c09ac97-eb63-4252-bbb3-66ac10295d80)
-   可通過「使用者編輯」修改使用者名稱、權限及密碼。
    ![image](https://github.com/user-attachments/assets/74741c28-f969-4af8-984b-8206d16961bc)
    ![image](https://github.com/user-attachments/assets/aa4e36ca-c8d8-4375-9e26-37a719ba36f1)1

3. 建立任務流程

-   點擊側邊選單的「任務流程」->「新增任務流程」。
    ![image](https://github.com/user-attachments/assets/766f7cce-df62-46b4-85f9-853cd5f7c39a)
-   自訂任務流程，選擇是否透過電子郵件通知相關人員。
    ![image](https://github.com/user-attachments/assets/03c56496-d75c-4ff6-bb42-f7df1e6b53ae)
-   流程創建後不可再編輯，只能刪除，以避免流程變更導致系統異常。
    ![image](https://github.com/user-attachments/assets/a624b1e5-81f7-44a4-9460-d1f1fbf2bed0)

4. 建立任務

-   點選側邊選單中的「任務目錄」->「新增任務單」或直接點擊「新增任務」。
    ![image](https://github.com/user-attachments/assets/f94bbcdf-627c-4b2e-b400-14226ab49d6e)
-   任務流程需在創建任務時選定，提交後不可修改。
    ![image](https://github.com/user-attachments/assets/fb314040-9db4-4af1-aac5-d597b2351ef4)
-   任務創建後，任務列表會顯示任務是否已被指派，尚未指派的任務可通過連結進行指派。
-   ![image](https://github.com/user-attachments/assets/5b966985-2904-46e6-a6e8-f762b27beeef)


5. 執行任務

任務指派後，負責的使用者可以查看並處理任務，提交進度後系統將會通知下一位執行者。
![image](https://github.com/user-attachments/assets/2811646e-12ac-4cb5-8b6e-14263fd7c673)
![image](https://github.com/user-attachments/assets/71661345-1cf1-4327-af1d-a29dc8d0c193)

6. 儀錶板
   儀錶板顯示使用者的近期任務情況，包含總任務數、被指派的任務數，以及已完成與未完成的任務狀態。
![image](https://github.com/user-attachments/assets/2278ba6e-30a7-4285-8062-1f1854acc8e1)

---

## 結語

本系統的開發歷時約 100 小時，過程中借助 ChatGPT 來快速掌握各類套件的使用方法，並加快前端互動開發進度。儘管目前為初版階段，系統架構仍需優化，但未來將會根據需求進行持續更新。

這樣的修改讓 README 文件結構更為清晰，同時語法及拼字錯誤也已修正。你可以依需求進一步調整內容或補充細節。
