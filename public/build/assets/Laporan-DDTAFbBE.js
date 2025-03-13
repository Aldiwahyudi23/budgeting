import{d as u,j as k,m as y,c as D,o as a,w as M,a as t,p as h,e as d,F as m,h as g,t as l,v as f,n as B,W as S}from"./app-DlL2FaVv.js";import{A as L}from"./AppLayout-BVtQ3Tdl.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const C={class:"p-4"},F={class:"bg-white p-6 rounded-lg shadow-md mb-6"},j={class:"grid grid-cols-1 sm:grid-cols-3 gap-4"},T=["value"],A=["value"],I={class:"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6"},z={class:"bg-white p-6 rounded-lg shadow-md"},J={class:"flex items-center"},N={class:"ml-4"},V={class:"text-2xl font-bold text-red-600"},K={class:"text-sm text-gray-500"},Y={class:"bg-white p-6 rounded-lg shadow-md"},G={class:"flex items-center"},P={class:"ml-4"},R={class:"text-2xl font-bold text-green-600"},U={class:"text-sm text-gray-500"},W={class:"bg-white p-6 rounded-lg shadow-md"},E={class:"flex items-center"},O={class:"ml-4"},q={class:"text-2xl font-bold text-blue-600"},H={class:"bg-white p-6 rounded-lg shadow-md"},Q={class:"flex items-center"},X={class:"ml-4"},Z={class:"text-2xl font-bold text-purple-600"},$={class:"text-sm text-gray-500"},tt={class:"bg-white p-6 rounded-lg shadow-md"},et={class:"min-w-full"},st={class:"py-2"},lt={class:"py-2"},ot={class:"py-2"},it={__name:"Laporan",setup(at){const n=u(new Date().getFullYear()),c=u(new Date().getMonth()+1),_=u(Array.from({length:10},(o,e)=>new Date().getFullYear()-e)),v=u(["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"]),r=u({total_expenses:"",total_income:"",total_savings:"",net_balance:"",transactions:[]}),i=o=>new Intl.NumberFormat("id-ID",{style:"currency",currency:"IDR"}).format(o),w=o=>new Date(o).toLocaleDateString("id-ID"),p=k(()=>v.value[c.value-1]),x=async()=>{S.get(route("laporan"),{year:n.value,month:c.value},{preserveState:!0,onSuccess:o=>{r.value=o.props.report}})};return y(()=>{x()}),(o,e)=>(a(),D(L,{title:"Laporan Keuangan"},{default:M(()=>[t("div",C,[e[16]||(e[16]=t("h1",{class:"text-2xl font-bold mb-6"},"Laporan Keuangan",-1)),t("div",F,[e[4]||(e[4]=t("h2",{class:"text-lg font-semibold mb-4"},"Filter Laporan",-1)),t("div",j,[t("div",null,[e[2]||(e[2]=t("label",{class:"block text-sm font-medium text-gray-700"},"Tahun",-1)),h(t("select",{"onUpdate:modelValue":e[0]||(e[0]=s=>n.value=s),class:"mt-1 block w-full border rounded-md p-2"},[(a(!0),d(m,null,g(_.value,s=>(a(),d("option",{key:s,value:s},l(s),9,T))),128))],512),[[f,n.value]])]),t("div",null,[e[3]||(e[3]=t("label",{class:"block text-sm font-medium text-gray-700"},"Bulan",-1)),h(t("select",{"onUpdate:modelValue":e[1]||(e[1]=s=>c.value=s),class:"mt-1 block w-full border rounded-md p-2"},[(a(!0),d(m,null,g(v.value,(s,b)=>(a(),d("option",{key:b,value:b+1},l(s),9,A))),128))],512),[[f,c.value]])]),t("div",{class:"flex items-end"},[t("button",{onClick:x,class:"bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"}," Terapkan Filter ")])])]),t("div",I,[t("div",z,[t("div",J,[e[6]||(e[6]=t("div",{class:"bg-red-100 p-3 rounded-full"},[t("svg",{class:"w-6 h-6 text-red-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"})])],-1)),t("div",N,[e[5]||(e[5]=t("h2",{class:"text-lg font-semibold"},"Total Pengeluaran",-1)),t("p",V,l(i(r.value.total_expenses)),1),t("p",K,l(p.value)+" "+l(n.value),1)])])]),t("div",Y,[t("div",G,[e[8]||(e[8]=t("div",{class:"bg-green-100 p-3 rounded-full"},[t("svg",{class:"w-6 h-6 text-green-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"})])],-1)),t("div",P,[e[7]||(e[7]=t("h2",{class:"text-lg font-semibold"},"Total Pendapatan",-1)),t("p",R,l(i(r.value.total_income)),1),t("p",U,l(p.value)+" "+l(n.value),1)])])]),t("div",W,[t("div",E,[e[11]||(e[11]=t("div",{class:"bg-blue-100 p-3 rounded-full"},[t("svg",{class:"w-6 h-6 text-blue-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"})])],-1)),t("div",O,[e[9]||(e[9]=t("h2",{class:"text-lg font-semibold"},"Saldo Tabungan",-1)),t("p",q,l(i(r.value.total_savings)),1),e[10]||(e[10]=t("p",{class:"text-sm text-gray-500"},"Saldo Saat Ini",-1))])])]),t("div",H,[t("div",Q,[e[13]||(e[13]=t("div",{class:"bg-purple-100 p-3 rounded-full"},[t("svg",{class:"w-6 h-6 text-purple-500",fill:"none",stroke:"currentColor",viewBox:"0 0 24 24"},[t("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"})])],-1)),t("div",X,[e[12]||(e[12]=t("h2",{class:"text-lg font-semibold"},"Saldo Bersih",-1)),t("p",Z,l(i(r.value.net_balance)),1),t("p",$,l(p.value)+" "+l(n.value),1)])])])]),e[17]||(e[17]=t("div",{class:"bg-white p-6 rounded-lg shadow-md mb-6"},[t("h2",{class:"text-lg font-semibold mb-4"},"Grafik Laporan"),t("div",{class:"h-64 bg-gray-100 rounded-lg flex items-center justify-center"},[t("p",{class:"text-gray-500"},"Grafik akan ditampilkan di sini")])],-1)),t("div",tt,[e[15]||(e[15]=t("h2",{class:"text-lg font-semibold mb-4"},"Detail Laporan",-1)),t("table",et,[e[14]||(e[14]=t("thead",null,[t("tr",null,[t("th",{class:"text-left py-2"},"Tanggal"),t("th",{class:"text-left py-2"},"Kategori"),t("th",{class:"text-left py-2"},"Deskripsi"),t("th",{class:"text-right py-2"},"Jumlah")])],-1)),t("tbody",null,[(a(!0),d(m,null,g(r.value.transactions,s=>(a(),d("tr",{key:s.id,class:"border-b"},[t("td",st,l(w(s.date)),1),t("td",lt,l(s.category),1),t("td",ot,l(s.description),1),t("td",{class:B(["text-right",s.type==="income"?"text-green-500":"text-red-500"])},l(s.type==="income"?"+":"-")+" "+l(i(s.amount)),3)]))),128))])])])])]),_:1}))}};export{it as default};
