import{d as p,m as v,c as x,o as h,w as l,a as e,b as n,u as a,P as r,t as o,e as f,F as b,h as k,n as w,g as y}from"./app-BAOndlI2.js";import{A as B}from"./AppLayout-BudElh9R.js";import{C}from"./auto-C0VlNTRY.js";import{_ as M}from"./_plugin-vue_export-helper-DlAUqK2U.js";const j={class:"p-4"},T={class:"grid grid-cols-2 sm:grid-cols-4 gap-4 mt-2"},_={class:"flex items-center"},A={class:"ml-3"},I={class:"text-xl font-bold text-purple-600"},D={class:"text-xs text-gray-500"},L={class:"block"},N={class:"block"},P={class:"flex flex-col items-center justify-center bg-red-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1"},z={class:"flex items-center"},S={class:"ml-3"},F={class:"text-xl font-bold text-blue-600"},V={class:"flex flex-col items-center justify-center bg-green-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1"},E={class:"flex items-center"},K={class:"ml-3"},R={class:"text-xl font-bold text-green-600"},H={class:"flex flex-col items-center justify-center bg-yellow-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1"},G={class:"flex items-center"},J={class:"ml-3"},W={class:"text-xl font-bold text-red-600"},Z={class:"grid grid-cols-4 sm:grid-cols-6 xl:grid-cols-8 gap-4 mt-6"},q={class:"grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6"},O={class:"bg-white p-6 rounded-lg shadow-md"},Q={class:"h-64"},U={class:"bg-white p-4 rounded-lg shadow-md"},X={class:"text-xs font-semibold"},Y={class:"text-[10px] text-gray-500"},$={class:"mt-6"},ee={class:"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"},te={__name:"Home",props:{totalSavingAmount:Number,totalIncome:Number,totalExpenses:Number,totalBalance:Number,totalBankBalance:Number,totalCashBalance:Number,transactions:Array,latestTransactions:Array},setup(d){const m=p(null);let c=null;const g=d,i=s=>new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR",minimumFractionDigits:0,maximumFractionDigits:0}).format(s);return v(()=>{m.value&&(c&&c.destroy(),c=new C(m.value,{type:"bar",data:{labels:["Pengeluaran","Pendapatan"],datasets:[{label:"Jumlah (Rp)",data:[g.totalExpenses,g.totalIncome],backgroundColor:["#f87171","#4ade80"],borderColor:["#dc2626","#16a34a"],borderWidth:1}]},options:{responsive:!0,maintainAspectRatio:!1,scales:{y:{beginAtZero:!0,ticks:{callback:function(s){return new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR"}).format(s)}}}},plugins:{legend:{display:!1}}}}))}),(s,t)=>(h(),x(B,{title:"Dashboard Keuangan"},{default:l(()=>[e("div",j,[e("div",T,[n(a(r),{href:s.route("account-bank.index"),class:"flex flex-col items-center justify-center bg-blue-100 p-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1"},{default:l(()=>[e("div",_,[t[1]||(t[1]=e("div",{class:"hidden sm:block bg-purple-100 p-2 rounded-full"},[e("svg",{class:"w-5 h-5 text-purple-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"})])],-1)),e("div",A,[t[0]||(t[0]=e("h2",{class:"text-base font-semibold"},"Saldo Bersih",-1)),e("p",I,o(i(d.totalBalance)),1),e("p",D,[e("span",L,"Bank: "+o(i(d.totalBankBalance)),1),e("span",N,"Tunai: "+o(i(d.totalCashBalance)),1)])])])]),_:1},8,["href"]),e("div",P,[e("div",z,[t[4]||(t[4]=e("div",{class:"hidden sm:block bg-blue-100 p-2 rounded-full"},[e("svg",{class:"w-5 h-5 text-blue-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"})])],-1)),e("div",S,[t[2]||(t[2]=e("h2",{class:"text-base font-semibold"},"Saldo Tabungan",-1)),e("p",F,o(i(d.totalSavingAmount)),1),t[3]||(t[3]=e("p",{class:"text-xs text-gray-500"},"Saldo saat ini",-1))])])]),e("div",V,[e("div",E,[t[7]||(t[7]=e("div",{class:"hidden sm:block bg-green-100 p-2 rounded-full"},[e("svg",{class:"w-5 h-5 text-green-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"})])],-1)),e("div",K,[t[5]||(t[5]=e("h2",{class:"text-base font-semibold"},"Total Pendapatan",-1)),e("p",R,o(i(d.totalIncome)),1),t[6]||(t[6]=e("p",{class:"text-xs text-gray-500"},"Bulan ini",-1))])])]),e("div",H,[e("div",G,[t[10]||(t[10]=e("div",{class:"hidden sm:block bg-red-100 p-2 rounded-full"},[e("svg",{class:"w-5 h-5 text-red-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"})])],-1)),e("div",J,[t[8]||(t[8]=e("h2",{class:"text-base font-semibold"},"Total Pengeluaran",-1)),e("p",W,o(i(d.totalExpenses)),1),t[9]||(t[9]=e("p",{class:"text-xs text-gray-500"},"Bulan ini",-1))])])])]),e("div",Z,[n(a(r),{href:s.route("bills.index"),class:"menu-item bg-blue-500"},{default:l(()=>t[11]||(t[11]=[e("div",{class:"bg-blue-600 p-3 rounded-full text-white"},[e("svg",{class:"icon",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M3 10h11m-1-6h4m-4 0v4m0-4L3 10m1 4h9m-9 0v6m0-6L3 14m11-4h4m-4 0v6m0-6L14 14m5-4h2m-2 0v6m0-6L19 14"})])],-1),e("span",null,"Tagihan",-1)])),_:1},8,["href"]),n(a(r),{href:s.route("debts.index"),class:"menu-item bg-red-500"},{default:l(()=>t[12]||(t[12]=[e("div",{class:"bg-red-600 p-3 rounded-full text-white"},[e("svg",{class:"icon",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M9 12h6m-3 3v-6m-8 3a9 9 0 1118 0 9 9 0 01-18 0z"})])],-1),e("span",null,"Hutang",-1)])),_:1},8,["href"]),n(a(r),{href:s.route("loans.index"),class:"menu-item bg-green-500"},{default:l(()=>t[13]||(t[13]=[e("div",{class:"bg-green-600 p-3 rounded-full text-white"},[e("svg",{class:"icon",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M5 13l4 4L19 7"})])],-1),e("span",null,"Pinjaman",-1)])),_:1},8,["href"]),n(a(r),{href:s.route("savings.index"),class:"menu-item bg-purple-500"},{default:l(()=>t[14]||(t[14]=[e("div",{class:"bg-purple-600 p-3 rounded-full text-white"},[e("svg",{class:"icon",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"})])],-1),e("span",null,"Tabungan",-1)])),_:1},8,["href"])]),e("div",q,[e("div",O,[t[15]||(t[15]=e("h2",{class:"text-lg font-semibold mb-4"},"Grafik Pengeluaran vs Pendapatan",-1)),e("div",Q,[e("canvas",{ref_key:"chartCanvas",ref:m},null,512)])]),e("div",U,[t[17]||(t[17]=e("h2",{class:"text-sm font-semibold mb-3"},"Transaksi Terbaru",-1)),e("ul",null,[(h(!0),f(b,null,k(g.latestTransactions,u=>(h(),f("li",{key:u.id,class:"flex items-center justify-between py-1 border-b"},[e("div",null,[e("p",X,o(u.category)+" "+o(u.description),1),e("p",Y,o(new Date(u.date).toLocaleDateString("id-ID",{day:"2-digit",month:"long",year:"numeric"})),1)]),e("p",{class:w(u.type==="income"?"text-green-500":"text-red-500")},o(u.type==="income"?"+":"-")+" "+o(i(u.amount)),3)]))),128))]),n(a(r),{href:s.route("laporan"),class:"text-blue-500 hover:text-blue-700 text-[12px] mt-3 block"},{default:l(()=>t[16]||(t[16]=[y(" Lihat Semua Transaksi → ")])),_:1},8,["href"])])]),e("div",$,[t[22]||(t[22]=e("h2",{class:"text-lg font-semibold mb-4"},"Akses Cepat",-1)),e("div",ee,[n(a(r),{href:s.route("expense.index"),class:"bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"},{default:l(()=>t[18]||(t[18]=[e("div",{class:"flex items-center"},[e("div",{class:"bg-red-100 p-3 rounded-full"},[e("svg",{class:"w-6 h-6 text-red-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"})])]),e("div",{class:"ml-4"},[e("h2",{class:"text-lg font-semibold"},"Pengeluaran"),e("p",{class:"text-sm text-gray-600"},"Kelola pengeluaran Anda")])],-1)])),_:1},8,["href"]),n(a(r),{href:s.route("income.index"),class:"bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"},{default:l(()=>t[19]||(t[19]=[e("div",{class:"flex items-center"},[e("div",{class:"bg-green-100 p-3 rounded-full"},[e("svg",{class:"w-6 h-6 text-green-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"})])]),e("div",{class:"ml-4"},[e("h2",{class:"text-lg font-semibold"},"Pendapatan"),e("p",{class:"text-sm text-gray-600"},"Kelola pendapatan Anda")])],-1)])),_:1},8,["href"]),n(a(r),{href:s.route("savings.index"),class:"bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"},{default:l(()=>t[20]||(t[20]=[e("div",{class:"flex items-center"},[e("div",{class:"bg-blue-100 p-3 rounded-full"},[e("svg",{class:"w-6 h-6 text-blue-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"})])]),e("div",{class:"ml-4"},[e("h2",{class:"text-lg font-semibold"},"Tabungan"),e("p",{class:"text-sm text-gray-600"},"Kelola tabungan Anda")])],-1)])),_:1},8,["href"]),n(a(r),{href:s.route("account-bank.index"),class:"bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow"},{default:l(()=>t[21]||(t[21]=[e("div",{class:"flex items-center"},[e("div",{class:"bg-purple-100 p-3 rounded-full"},[e("svg",{class:"w-6 h-6 text-purple-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"})])]),e("div",{class:"ml-4"},[e("h2",{class:"text-lg font-semibold"},"Laporan"),e("p",{class:"text-sm text-gray-600"},"Lihat laporan keuangan")])],-1)])),_:1},8,["href"])])])])]),_:1}))}},ae=M(te,[["__scopeId","data-v-04407578"]]);export{ae as default};
