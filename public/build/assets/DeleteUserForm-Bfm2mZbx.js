import{d as p,C as k,c as _,o as w,w as a,a as i,b as o,g as n,u as r,n as g,A}from"./app-Dc4t1LEb.js";import{b as v,a as y}from"./DialogModal-kA9OwAgh.js";import{_ as d}from"./DangerButton-DxEvAe4t.js";import{_ as x}from"./InputError-Dmp8YO-4.js";import{_ as C}from"./SecondaryButton-HQ6C-wiq.js";import{_ as b}from"./TextInput-CUKLywm6.js";/* empty css                                                                       */import{_ as H}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./SectionTitle-Cuapc0Rm.js";const U={class:"mt-5"},V={class:"mt-4"},$={__name:"DeleteUserForm",setup(S){const t=p(!1),u=p(null),e=k({password:""}),f=()=>{t.value=!0,setTimeout(()=>u.value.focus(),250)},m=()=>{e.delete(route("current-user.destroy"),{preserveScroll:!0,onSuccess:()=>l(),onError:()=>u.value.focus(),onFinish:()=>e.reset()})},l=()=>{t.value=!1,e.reset()};return(B,s)=>(w(),_(y,null,{title:a(()=>s[1]||(s[1]=[n(" Hapus Akun ")])),description:a(()=>s[2]||(s[2]=[n(" Hapus akun Anda secara permanen. ")])),content:a(()=>[s[8]||(s[8]=i("div",{class:"max-w-xl text-sm text-gray-600"}," Setelah akun Anda dihapus, semua data dan resource yang terkait akan dihapus secara permanen. Sebelum menghapus akun, harap unduh data atau informasi yang ingin Anda simpan. ",-1)),i("div",U,[o(d,{onClick:f},{default:a(()=>s[3]||(s[3]=[n(" Hapus Akun ")])),_:1})]),o(v,{show:t.value,onClose:l},{title:a(()=>s[4]||(s[4]=[n(" Hapus Akun ")])),content:a(()=>[s[5]||(s[5]=n(" Apakah Anda yakin ingin menghapus akun Anda? Setelah akun dihapus, semua data dan resource akan dihapus secara permanen. Harap masukkan password Anda untuk mengonfirmasi penghapusan akun. ")),i("div",V,[o(b,{ref_key:"passwordInput",ref:u,modelValue:r(e).password,"onUpdate:modelValue":s[0]||(s[0]=c=>r(e).password=c),type:"password",class:"mt-1 block w-full md:w-3/4",placeholder:"Password",autocomplete:"current-password",onKeyup:A(m,["enter"])},null,8,["modelValue"]),o(x,{message:r(e).errors.password,class:"mt-2"},null,8,["message"])])]),footer:a(()=>[o(C,{onClick:l},{default:a(()=>s[6]||(s[6]=[n(" Batal ")])),_:1}),o(d,{class:g(["ms-3",{"opacity-25":r(e).processing}]),disabled:r(e).processing,onClick:m},{default:a(()=>s[7]||(s[7]=[n(" Hapus Akun ")])),_:1},8,["class","disabled"])]),_:1},8,["show"])]),_:1}))}},M=H($,[["__scopeId","data-v-84390784"]]);export{M as default};
