import{d as S,C as j,l as E,c as P,o as i,w as d,a,b as l,e as r,g as u,F as U,h as B,f as v,t as g,n as F,q as I,u as n,p as _,v as D,y as V,W as J}from"./app-TmrfSb3x.js";import{A as K}from"./AppLayout-7w71YRRM.js";import{_ as O}from"./CustomModal-BcH10ZXL.js";import{_ as x}from"./PrimaryButton-BYL_k8AT.js";import{_ as q}from"./SecondaryButton-D9UdVSlF.js";import{_ as p}from"./InputLabel-CTPtoiEh.js";import{_ as y}from"./TextInput-mP6luwjN.js";import{_ as c}from"./InputError-C9WnNx8b.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const L={class:"p-4"},W={class:"container mx-auto p-2"},z={class:"flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-4 rounded-lg shadow-md mb-2"},G={key:0,class:"grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"},Q={class:"flex items-center justify-between"},R={class:"text-lg font-semibold"},X={class:"text-sm text-gray-500"},Y={class:"text-xl font-bold text-purple-600"},Z={class:"text-sm text-gray-500"},ee={key:0,class:"text-sm text-green-500"},te={key:1,class:"text-sm text-blue-500"},ae={class:"mt-4 flex space-x-2"},se={key:1,class:"text-center bg-white p-2 rounded-lg shadow-md"},ne={class:"mb-4"},le={class:"mb-4"},oe={class:"mb-4"},ie={class:"mb-4"},re={class:"mb-4"},ue={key:0,class:"mb-4"},me=["value"],de={key:1,class:"mb-4"},ge={class:"mb-4"},pe={class:"flex items-center"},ce={class:"mb-4"},fe={class:"flex items-center"},ke={class:"mb-4"},_e={class:"flex items-center"},ye={class:"flex justify-end mt-4"},Se={__name:"Index",props:{debts:Array},setup(C){const h=S(!1),m=S(!1),t=j({id:null,name:"",kategori:"",amount:"",note:"",type:"personal",due_date:null,tenor_months:null,is_active:!1,reminder:!1,auto:!1}),w=o=>o?new Intl.NumberFormat("id-ID").format(o.replace(/\D/g,"")):"";E(()=>{t&&(t.amount=w(String(t.amount)))});const H=(o,e=null)=>{var s,f,k;m.value=o==="edit",m.value&&e?(t.id=e.id,t.name=((s=e.sub_category)==null?void 0:s.name)||"",t.kategori=((f=e.sub_category)==null?void 0:f.name)||"",t.note=e.note,t.amount=w(String(e.amount)),t.type=e.type,t.due_date=e.due_date,t.tenor_months=e.tenor_months,t.reminder=!!e.reminder,t.auto=!!e.auto,t.is_active=!!((k=e.sub_category)!=null&&k.is_active)):t.reset(),h.value=!0},b=()=>{t.reset(),h.value=!1},A=()=>{t.amount=t.amount.replace(/\D/g,""),m.value?t.put(route("debts.update",t.id),{onSuccess:()=>b()}):t.post(route("debts.store"),{onSuccess:()=>b()})},$=o=>{confirm("Apakah Anda yakin ingin menghapus hutang ini?")&&J.delete(route("debts.destroy",o))},M=o=>o?new Date(o).getDate():"";return(o,e)=>(i(),P(K,{title:"Kelola Hutang"},{default:d(()=>[a("div",L,[a("div",W,[a("div",z,[e[12]||(e[12]=a("div",null,[a("h1",{class:"text-xl font-semibold text-gray-800"},"Kelola Hutang"),a("p",{class:"text-sm text-gray-600 mt-1"}," Halaman ini digunakan untuk mengelola dan menambahkan data hutang seperti hutang pribadi, cicilan, atau hutang bisnis. ")],-1)),l(x,{onClick:e[0]||(e[0]=s=>H("create")),class:"mt-4 sm:mt-0"},{default:d(()=>e[11]||(e[11]=[u("Tambah Hutang")])),_:1})]),C.debts.length>0?(i(),r("div",G,[(i(!0),r(U,null,B(C.debts,s=>{var f,k,T;return i(),r("div",{key:s.id,class:"bg-white p-6 rounded-lg shadow-md"},[a("div",Q,[a("h2",R,g(((f=s.sub_category)==null?void 0:f.name)||"Tanpa Kategori"),1),a("span",{class:F(["px-2 py-1 text-xs font-semibold rounded-lg",(k=s.sub_category)!=null&&k.is_active?"bg-green-100 text-green-600":"bg-red-100 text-red-600"])},g((T=s.sub_category)!=null&&T.is_active?"Aktif":"Tidak Aktif"),3)]),a("p",X,g(s.note),1),a("p",Y,g(w(s.amount)),1),a("p",Z,"Tanggal Jatuh Tempo: "+g(M(s.due_date)),1),s.reminder?(i(),r("p",ee," Hutang ini di set Pengingat dan akan diingatkan selalu. ")):v("",!0),s.auto?(i(),r("p",te," Setiap tanggal jatuh tempo, hutang akan otomatis tersimpan ke data. ")):v("",!0),a("div",ae,[l(x,{onClick:N=>H("edit",s)},{default:d(()=>e[13]||(e[13]=[u("Edit")])),_:2},1032,["onClick"]),l(x,{class:"bg-red-600 hover:bg-red-700",onClick:N=>$(s.id)},{default:d(()=>e[14]||(e[14]=[u("Hapus")])),_:2},1032,["onClick"])])])}),128))])):(i(),r("div",se,e[15]||(e[15]=[a("p",{class:"text-gray-500 text-sm"},"Belum ada hutang yang tercatat. Silakan tambahkan hutang baru.",-1)]))),e[16]||(e[16]=a("div",{class:"mt-4 bg-gray-100 p-2 rounded-lg shadow-md"},[a("h2",{class:"text-lg font-semibold text-gray-800"},"Informasi Mengenai Hutang"),a("p",{class:"text-sm text-gray-600 mt-2"}," Halaman ini digunakan untuk mencatat hutang yang harus dibayar, baik itu hutang pribadi, cicilan, atau hutang bisnis. "),a("p",{class:"text-sm text-gray-600 mt-2"},[u(" Untuk pembayaran atau transaksi, silakan lakukan melalui halaman "),a("strong",null,"Transaksi Pengeluaran (Expenses)"),u(". Pilih kategori "),a("strong",null,"Hutang"),u(" dan tambahkan keterangan sesuai jenis hutang yang dibayarkan. ")])],-1))]),l(O,{show:h.value,title:m.value?"Edit Hutang":"Tambah Hutang",onClose:b},{content:d(()=>[a("form",{onSubmit:I(A,["prevent"])},[a("div",ne,[l(p,{for:"name",value:"Nama Hutang"}),l(y,{id:"name",modelValue:n(t).name,"onUpdate:modelValue":e[1]||(e[1]=s=>n(t).name=s),class:"block w-full",disabled:m.value,readonly:m.value},null,8,["modelValue","disabled","readonly"]),l(c,{message:n(t).errors.name},null,8,["message"])]),a("div",le,[l(p,{for:"kategori",value:"Kategori"}),l(y,{id:"kategori",modelValue:n(t).kategori,"onUpdate:modelValue":e[2]||(e[2]=s=>n(t).kategori=s),class:"block w-full"},null,8,["modelValue"]),l(c,{message:n(t).errors.kategori},null,8,["message"])]),a("div",oe,[l(p,{for:"amount",value:"Jumlah Hutang"}),l(y,{id:"amount",type:"number",modelValue:n(t).amount,"onUpdate:modelValue":e[3]||(e[3]=s=>n(t).amount=s),class:"block w-full",required:""},null,8,["modelValue"]),l(c,{message:n(t).errors.amount},null,8,["message"])]),a("div",ie,[l(p,{for:"note",value:"Catatan"}),l(y,{id:"note",modelValue:n(t).note,"onUpdate:modelValue":e[4]||(e[4]=s=>n(t).note=s),class:"block w-full"},null,8,["modelValue"]),l(c,{message:n(t).errors.note},null,8,["message"])]),a("div",re,[l(p,{for:"type",value:"Tipe Hutang"}),_(a("select",{id:"type","onUpdate:modelValue":e[5]||(e[5]=s=>n(t).type=s),class:"block w-full"},e[17]||(e[17]=[a("option",{value:"personal"},"Personal",-1),a("option",{value:"installment"},"Cicilan",-1),a("option",{value:"business"},"Bisnis",-1)]),512),[[D,n(t).type]]),l(c,{message:n(t).errors.type},null,8,["message"])]),n(t).type==="installment"?(i(),r("div",ue,[l(p,{for:"due_date",value:"Tanggal Jatuh Tempo"}),_(a("select",{id:"due_date","onUpdate:modelValue":e[6]||(e[6]=s=>n(t).due_date=s),class:"block w-full"},[(i(),r(U,null,B(31,s=>a("option",{key:s,value:s},g(s),9,me)),64))],512),[[D,n(t).due_date]]),l(c,{message:n(t).errors.due_date},null,8,["message"])])):v("",!0),n(t).type==="installment"?(i(),r("div",de,[l(p,{for:"tenor_months",value:"Tenor (Bulan)"}),l(y,{id:"tenor_months",type:"number",modelValue:n(t).tenor_months,"onUpdate:modelValue":e[7]||(e[7]=s=>n(t).tenor_months=s),class:"block w-full"},null,8,["modelValue"]),l(c,{message:n(t).errors.tenor_months},null,8,["message"])])):v("",!0),a("div",ge,[a("label",pe,[_(a("input",{type:"checkbox","onUpdate:modelValue":e[8]||(e[8]=s=>n(t).is_active=s),class:"mr-2"},null,512),[[V,n(t).is_active]]),e[18]||(e[18]=a("span",null,"Status",-1))]),e[19]||(e[19]=a("p",{class:"text-sm text-gray-500"},"Jika Aktif akan bisa Transaksi",-1))]),a("div",ce,[a("label",fe,[_(a("input",{type:"checkbox","onUpdate:modelValue":e[9]||(e[9]=s=>n(t).reminder=s),class:"mr-2"},null,512),[[V,n(t).reminder]]),e[20]||(e[20]=a("span",null,"Pengingat",-1))]),e[21]||(e[21]=a("p",{class:"text-sm text-gray-500"},"Akan diingatkan H-1 dari Tanggal",-1))]),a("div",ke,[a("label",_e,[_(a("input",{type:"checkbox","onUpdate:modelValue":e[10]||(e[10]=s=>n(t).auto=s),class:"mr-2"},null,512),[[V,n(t).auto]]),e[22]||(e[22]=a("span",null,"Otomatis",-1))]),e[23]||(e[23]=a("p",{class:"text-sm text-gray-500"},"Secara Otomatis Masuk data sesuai tanggal",-1))]),a("div",ye,[l(q,{type:"button",onClick:b},{default:d(()=>e[24]||(e[24]=[u("Batal")])),_:1}),l(x,{class:"ml-3",type:"submit"},{default:d(()=>[u(g(m.value?"Update":"Simpan"),1)]),_:1})])],32)]),_:1},8,["show","title"])])]),_:1}))}};export{Se as default};
