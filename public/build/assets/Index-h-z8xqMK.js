import{d as A,C as M,k as P,l as N,c as E,o as m,w as r,a as t,b as n,e as u,g as o,F as H,h as K,f as U,t as g,n as F,q as L,u as i,p as v,y as w,W as O}from"./app-DFnBv35t.js";import{A as J}from"./AppLayout-Xffz29Yr.js";import{_ as W}from"./CustomModal-DCuqDAKQ.js";import{_ as c}from"./PrimaryButton-Czu5GLi4.js";import{_ as q}from"./SecondaryButton-5wc5QLmn.js";import{_ as k}from"./InputLabel-OZohKoC_.js";import{_ as x}from"./TextInput-Ciq2pKpP.js";import{_ as b}from"./InputError-BqN00GJk.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const z={class:"p-4"},R={class:"container mx-auto p-2"},G={class:"flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-4 rounded-lg shadow-md mb-2"},Q={key:0,class:"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"},X={class:"flex items-center justify-between"},Y={class:"text-lg font-semibold"},Z={class:"text-sm text-gray-500"},aa={class:"text-xl font-bold text-purple-600"},ta={class:"text-sm text-gray-500"},ea={key:0,class:"text-sm text-green-500"},sa={key:1,class:"text-sm text-blue-500"},na={class:"mt-4 flex justify-between items-center"},la={class:"flex space-x-2"},ia=["href"],oa={key:1,class:"text-center bg-white p-2 rounded-lg shadow-md"},ra={class:"mb-4"},da={class:"mb-4"},ma={class:"mb-4"},ua={class:"mb-4"},ga={class:"mb-4"},pa={class:"flex items-center"},fa={class:"mb-4"},ca={class:"flex items-center"},ka={class:"mb-4"},xa={class:"flex items-center"},ba={class:"flex justify-end mt-4"},Aa={__name:"Index",props:{bills:Array},setup(T){const y=A(!1),d=A(!1),e=M({id:null,name:"",note:"",amount:"",balance:"",date:"",reminder:!1,auto:!1,is_active:!1}),h=l=>l?new Intl.NumberFormat("id-ID").format(l):"",D=l=>l?l.replace(/\./g,""):"",_=P({get:()=>h(e.amount),set:l=>{e.amount=D(l)}});N(()=>{_.value=h(e.amount)});const B=(l,a=null)=>{var s,p;d.value=l==="edit",d.value&&a?(e.id=a.id,e.name=((s=a.sub_category)==null?void 0:s.name)||"",e.note=a.note,e.amount=a.amount,e.balance=a.balance,e.date=a.date,e.reminder=!!a.reminder,e.auto=!!a.auto,e.is_active=!!((p=a.sub_category)!=null&&p.is_active)):e.reset(),y.value=!0},f=()=>{e.reset(),y.value=!1},S=()=>{d.value?e.put(route("bills.update",e.id),{onSuccess:()=>f()}):e.post(route("bills.store"),{onSuccess:()=>f()})},$=l=>{confirm("Apakah Anda yakin ingin menghapus bill ini?")&&O.delete(route("bills.destroy",l))},j=l=>l?new Date(l).getDate():"";return(l,a)=>(m(),E(J,{title:"Kelola Bill"},{default:r(()=>[t("div",z,[t("div",R,[t("div",G,[a[9]||(a[9]=t("div",null,[t("h1",{class:"text-xl font-semibold text-gray-800"},"Kelola Tagihan Bulanan"),t("p",{class:"text-sm text-gray-600 mt-1"}," Halaman ini digunakan untuk mengelola dan menambahkan data tagihan bulanan seperti listrik, internet, dan tagihan rutin lainnya. ")],-1)),n(c,{onClick:a[0]||(a[0]=s=>B("create")),class:"mt-4 sm:mt-0"},{default:r(()=>a[8]||(a[8]=[o("Tambah Bill (Tagihan)")])),_:1})]),T.bills.length>0?(m(),u("div",Q,[(m(!0),u(H,null,K(T.bills,s=>{var p,V,C;return m(),u("div",{key:s.id,class:"bg-white p-6 rounded-lg shadow-md"},[t("div",X,[t("h2",Y,g(((p=s.sub_category)==null?void 0:p.name)||"Tanpa Kategori"),1),t("span",{class:F(["px-2 py-1 text-xs font-semibold rounded-lg",(V=s.sub_category)!=null&&V.is_active?"bg-green-100 text-green-600":"bg-red-100 text-red-600"])},g((C=s.sub_category)!=null&&C.is_active?"Aktif":"Tidak Aktif"),3)]),t("p",Z,g(s.note),1),t("p",aa,"Rp "+g(h(s.amount)),1),t("p",ta,"Tanggal Batas Akhir : "+g(j(s.date)),1),s.reminder?(m(),u("p",ea," Tagihan ini di set Pengingat dan akan diingatkan selalu. ")):U("",!0),s.auto?(m(),u("p",sa," Setiap tanggal jatuh tempo, tagihan akan otomatis tersimpan ke data. ")):U("",!0),t("div",na,[t("div",la,[n(c,{onClick:I=>B("edit",s)},{default:r(()=>a[10]||(a[10]=[o("Edit")])),_:2},1032,["onClick"]),n(c,{class:"bg-red-600 hover:bg-red-700",onClick:I=>$(s.id)},{default:r(()=>a[11]||(a[11]=[o("Hapus")])),_:2},1032,["onClick"])]),t("a",{href:l.route("history_pembayaran_bill",{id:s.id}),class:"text-sm text-blue-500 hover:text-blue-700 underline"}," History Pembayaran ",8,ia)])])}),128))])):(m(),u("div",oa,a[12]||(a[12]=[t("p",{class:"text-gray-500 text-sm"},"Belum ada tagihan yang tercatat. Silakan tambahkan tagihan baru.",-1)]))),a[13]||(a[13]=t("div",{class:"mt-4 bg-gray-100 p-2 rounded-lg shadow-md"},[t("h2",{class:"text-lg font-semibold text-gray-800"},"Informasi Mengenai Tagihan"),t("p",{class:"text-sm text-gray-600 mt-2"}," Halaman ini digunakan untuk mencatat tagihan bulanan yang harus dibayar setiap bulannya, seperti bayar kost, listrik, wifi, atau tagihan rutin lainnya. Berikut cara menambahkan tagihan: "),t("ul",{class:"text-sm text-gray-600 mt-2 list-disc list-inside"},[t("li",null,"Klik tombol di atas kanan untuk menambahkan tagihan baru."),t("li",null,'Isi nama tagihan (contoh: "Bayar Listrik").'),t("li",null,"Masukkan nominal tagihan."),t("li",null,"Pilih tanggal jatuh tempo."),t("li",null,[o("Pilih mode pembayaran: "),t("ul",{class:"list-circle list-inside ml-4"},[t("li",null,[t("strong",null,"Auto"),o(": Jika pembayaran dilakukan otomatis (misalnya melalui admin bank).")]),t("li",null,[t("strong",null,"Pengingat"),o(": Untuk mendapatkan notifikasi sebelum jatuh tempo.")])])]),t("li",null,'Klik "Tambahkan" untuk menyimpan tagihan.')]),t("p",{class:"text-sm text-gray-600 mt-2"},[o(" Untuk pembayaran atau transaksi, silakan lakukan melalui halaman "),t("strong",null,"Transaksi Pengeluaran (Expenses)"),o(". Pilih kategori "),t("strong",null,"Bill (Tagihan)"),o(" dan tambahkan keterangan sesuai jenis tagihan yang dibayarkan. ")])],-1))]),n(W,{show:y.value,title:d.value?"Edit Bill (Tagihan)":"Tambah Bill (Tagihan)",onClose:f},{content:r(()=>[t("form",{onSubmit:L(S,["prevent"])},[t("div",ra,[n(k,{for:"name"},{default:r(()=>a[14]||(a[14]=[o(" Nama Bill (Tagihan) "),t("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),n(x,{id:"name",modelValue:i(e).name,"onUpdate:modelValue":a[1]||(a[1]=s=>i(e).name=s),class:"block w-full",disabled:d.value,readonly:d.value},null,8,["modelValue","disabled","readonly"]),n(b,{message:i(e).errors.name},null,8,["message"])]),t("div",da,[n(k,{for:"note"},{default:r(()=>a[15]||(a[15]=[o(" Catatan ")])),_:1}),n(x,{id:"note",modelValue:i(e).note,"onUpdate:modelValue":a[2]||(a[2]=s=>i(e).note=s),class:"block w-full"},null,8,["modelValue"]),n(b,{message:i(e).errors.note},null,8,["message"])]),t("div",ma,[n(k,{for:"amount"},{default:r(()=>a[16]||(a[16]=[o(" Nominal Tagihan "),t("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),n(x,{id:"amount",type:"text",modelValue:_.value,"onUpdate:modelValue":a[3]||(a[3]=s=>_.value=s),onInput:l.handleAmountInput,class:"block w-full"},null,8,["modelValue","onInput"]),n(b,{message:i(e).errors.amount},null,8,["message"])]),t("div",ua,[n(k,{for:"date"},{default:r(()=>a[17]||(a[17]=[o(" Tanggal Tagihan "),t("span",{class:"text-red-500 text-sm"},"*",-1)])),_:1}),n(x,{id:"date",type:"date",modelValue:i(e).date,"onUpdate:modelValue":a[4]||(a[4]=s=>i(e).date=s),class:"block w-full"},null,8,["modelValue"]),n(b,{message:i(e).errors.date},null,8,["message"])]),t("div",ga,[t("label",pa,[v(t("input",{type:"checkbox","onUpdate:modelValue":a[5]||(a[5]=s=>i(e).is_active=s),class:"mr-2"},null,512),[[w,i(e).is_active]]),a[18]||(a[18]=t("span",null,"Status",-1))]),a[19]||(a[19]=t("p",{class:"text-sm text-gray-500"},"Jika Aktif akan bisa Transaksi",-1))]),t("div",fa,[t("label",ca,[v(t("input",{type:"checkbox","onUpdate:modelValue":a[6]||(a[6]=s=>i(e).reminder=s),class:"mr-2"},null,512),[[w,i(e).reminder]]),a[20]||(a[20]=t("span",null,"Pengingat",-1))]),a[21]||(a[21]=t("p",{class:"text-sm text-gray-500"},"Akan diingatkan H-1 dari Tanggal",-1))]),t("div",ka,[t("label",xa,[v(t("input",{type:"checkbox","onUpdate:modelValue":a[7]||(a[7]=s=>i(e).auto=s),class:"mr-2"},null,512),[[w,i(e).auto]]),a[22]||(a[22]=t("span",null,"Otomatis",-1))]),a[23]||(a[23]=t("p",{class:"text-sm text-gray-500"},"Secara Otomatis Masuk data sesuai tanggal",-1))]),t("div",ba,[n(q,{type:"button",onClick:f},{default:r(()=>a[24]||(a[24]=[o("Batal")])),_:1}),n(c,{class:"ml-3",type:"submit"},{default:r(()=>[o(g(d.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"])])]),_:1}))}};export{Aa as default};
