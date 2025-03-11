import{c as u,o as m,w as l,a as s,b as n,u as d,P as r,t as i,g}from"./app-Ba0vgL21.js";import{A as c}from"./AppLayout-BImQPAyd.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const p={class:"p-4"},x={class:"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6"},h={class:"flex items-center"},b={class:"ml-3"},v={class:"text-xl font-bold text-purple-600"},f={class:"text-xs text-gray-500"},w={class:"block"},k={class:"block"},B={class:"bg-white p-4 rounded-lg shadow-md"},y={class:"flex items-center"},j={class:"ml-3"},M={class:"text-xl font-bold text-blue-600"},C={class:"bg-white p-4 rounded-lg shadow-md"},N={class:"flex items-center"},A={class:"ml-3"},R={class:"text-xl font-bold text-green-600"},T={class:"bg-white p-4 rounded-lg shadow-md"},P={class:"flex items-center"},S={class:"ml-3"},z={class:"text-xl font-bold text-red-600"},L={class:"grid grid-cols-1 lg:grid-cols-2 gap-6"},V={class:"bg-white p-6 rounded-lg shadow-md"},_={class:"mt-6"},I={class:"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"},O={__name:"Home",props:{totalSavingAmount:Number,totalIncome:Number,totalExpenses:Number,totalBalance:Number,totalBankBalance:Number,totalCashBalance:Number,transactions:Array},setup(o){const a=e=>new Intl.NumberFormat("id-ID").format(e);return(e,t)=>(m(),u(c,{title:"Dashboard Keuangan"},{default:l(()=>[s("div",p,[s("div",x,[n(d(r),{href:e.route("account-bank.index"),class:"bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow"},{default:l(()=>[s("div",h,[t[1]||(t[1]=s("div",{class:"bg-purple-100 p-2 rounded-full"},[s("svg",{class:"w-5 h-5 text-purple-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"})])],-1)),s("div",b,[t[0]||(t[0]=s("h2",{class:"text-base font-semibold"},"Saldo Bersih",-1)),s("p",v,"Rp "+i(a(o.totalBalance)),1),s("p",f,[s("span",w,"Bank: Rp "+i(a(o.totalBankBalance)),1),s("span",k,"Tunai: Rp "+i(a(o.totalCashBalance)),1)])])])]),_:1},8,["href"]),s("div",B,[s("div",y,[t[4]||(t[4]=s("div",{class:"bg-blue-100 p-2 rounded-full"},[s("svg",{class:"w-5 h-5 text-blue-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"})])],-1)),s("div",j,[t[2]||(t[2]=s("h2",{class:"text-base font-semibold"},"Saldo Tabungan",-1)),s("p",M,"Rp"+i(a(o.totalSavingAmount)),1),t[3]||(t[3]=s("p",{class:"text-xs text-gray-500"},"Saldo saat ini",-1))])])]),s("div",C,[s("div",N,[t[7]||(t[7]=s("div",{class:"bg-green-100 p-2 rounded-full"},[s("svg",{class:"w-5 h-5 text-green-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"})])],-1)),s("div",A,[t[5]||(t[5]=s("h2",{class:"text-base font-semibold"},"Total Pendapatan",-1)),s("p",R,"Rp"+i(a(o.totalIncome)),1),t[6]||(t[6]=s("p",{class:"text-xs text-gray-500"},"Bulan ini",-1))])])]),s("div",T,[s("div",P,[t[10]||(t[10]=s("div",{class:"bg-red-100 p-2 rounded-full"},[s("svg",{class:"w-5 h-5 text-red-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"})])],-1)),s("div",S,[t[8]||(t[8]=s("h2",{class:"text-base font-semibold"},"Total Pengeluaran",-1)),s("p",z,"Rp"+i(a(o.totalExpenses)),1),t[9]||(t[9]=s("p",{class:"text-xs text-gray-500"},"Bulan ini",-1))])])])]),s("div",L,[t[14]||(t[14]=s("div",{class:"bg-white p-6 rounded-lg shadow-md"},[s("h2",{class:"text-lg font-semibold mb-4"},"Grafik Pengeluaran"),s("div",{class:"h-64 bg-gray-100 rounded-lg flex items-center justify-center"},[s("p",{class:"text-gray-500"},"Grafik akan ditampilkan di sini")])],-1)),s("div",V,[t[12]||(t[12]=s("h2",{class:"text-lg font-semibold mb-4"},"Transaksi Terbaru",-1)),t[13]||(t[13]=s("ul",null,[s("li",{class:"flex items-center justify-between py-2 border-b"},[s("div",null,[s("p",{class:"font-semibold"},"Belanja Bulanan"),s("p",{class:"text-sm text-gray-500"},"12 Oktober 2023")]),s("p",{class:"text-red-500"},"- Rp 1.500.000")]),s("li",{class:"flex items-center justify-between py-2 border-b"},[s("div",null,[s("p",{class:"font-semibold"},"Gaji Bulanan"),s("p",{class:"text-sm text-gray-500"},"10 Oktober 2023")]),s("p",{class:"text-green-500"},"+ Rp 5.000.000")]),s("li",{class:"flex items-center justify-between py-2 border-b"},[s("div",null,[s("p",{class:"font-semibold"},"Bayar Listrik"),s("p",{class:"text-sm text-gray-500"},"8 Oktober 2023")]),s("p",{class:"text-red-500"},"- Rp 500.000")])],-1)),n(d(r),{href:e.route("expense.index"),class:"text-blue-500 hover:text-blue-700 text-sm mt-4 block"},{default:l(()=>t[11]||(t[11]=[g(" Lihat Semua Transaksi → ")])),_:1},8,["href"])])]),s("div",_,[t[19]||(t[19]=s("h2",{class:"text-lg font-semibold mb-4"},"Akses Cepat",-1)),s("div",I,[n(d(r),{href:e.route("expense.index"),class:"bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"},{default:l(()=>t[15]||(t[15]=[s("div",{class:"flex items-center"},[s("div",{class:"bg-red-100 p-3 rounded-full"},[s("svg",{class:"w-6 h-6 text-red-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"})])]),s("div",{class:"ml-4"},[s("h2",{class:"text-lg font-semibold"},"Pengeluaran"),s("p",{class:"text-sm text-gray-600"},"Kelola pengeluaran Anda")])],-1)])),_:1},8,["href"]),n(d(r),{href:e.route("income.index"),class:"bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"},{default:l(()=>t[16]||(t[16]=[s("div",{class:"flex items-center"},[s("div",{class:"bg-green-100 p-3 rounded-full"},[s("svg",{class:"w-6 h-6 text-green-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"})])]),s("div",{class:"ml-4"},[s("h2",{class:"text-lg font-semibold"},"Pendapatan"),s("p",{class:"text-sm text-gray-600"},"Kelola pendapatan Anda")])],-1)])),_:1},8,["href"]),n(d(r),{href:e.route("savings.index"),class:"bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"},{default:l(()=>t[17]||(t[17]=[s("div",{class:"flex items-center"},[s("div",{class:"bg-blue-100 p-3 rounded-full"},[s("svg",{class:"w-6 h-6 text-blue-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"})])]),s("div",{class:"ml-4"},[s("h2",{class:"text-lg font-semibold"},"Tabungan"),s("p",{class:"text-sm text-gray-600"},"Kelola tabungan Anda")])],-1)])),_:1},8,["href"]),n(d(r),{href:e.route("account-bank.index"),class:"bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"},{default:l(()=>t[18]||(t[18]=[s("div",{class:"flex items-center"},[s("div",{class:"bg-purple-100 p-3 rounded-full"},[s("svg",{class:"w-6 h-6 text-purple-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"})])]),s("div",{class:"ml-4"},[s("h2",{class:"text-lg font-semibold"},"Laporan"),s("p",{class:"text-sm text-gray-600"},"Lihat laporan keuangan")])],-1)])),_:1},8,["href"])])])])]),_:1}))}};export{O as default};
