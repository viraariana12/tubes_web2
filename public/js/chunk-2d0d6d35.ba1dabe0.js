(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0d6d35"],{"73cf":function(a,r,e){"use strict";e.r(r);var s=function(){var a=this,r=a.$createElement,e=a._self._c||r;return e("v-container",{staticClass:"fill-height",attrs:{fluid:""}},[e("v-row",{attrs:{align:"center",justify:"center"}},[e("v-col",{attrs:{cols:"12",sm:"8",md:"4"}},[e("v-card",[e("v-toolbar",{attrs:{color:"blue",dark:"",flat:""}},[e("v-toolbar-title",[a._v("Pendaftaran Pengguna Baru")])],1),e("v-card-text",[e("v-text-field",{attrs:{label:"Nama","prepend-icon":"mdi-account","error-messages":a.error.nama},on:{focus:a.hapusError},model:{value:a.user.nama,callback:function(r){a.$set(a.user,"nama",r)},expression:"user.nama"}}),e("v-text-field",{attrs:{label:"Alamat E-Mail","prepend-icon":"mdi-account","error-messages":a.error.email},on:{focus:a.hapusError},model:{value:a.user.email,callback:function(r){a.$set(a.user,"email",r)},expression:"user.email"}}),e("v-text-field",{attrs:{label:"Kata Sandi","error-messages":a.error.password,"prepend-icon":"mdi-lock",type:"password"},on:{focus:a.hapusError},model:{value:a.user.password,callback:function(r){a.$set(a.user,"password",r)},expression:"user.password"}})],1),e("v-card-actions",[e("v-spacer"),e("v-btn",{attrs:{color:"success"},on:{click:a.cobaRegister}},[a._v("Daftar")])],1)],1)],1)],1)],1)},t=[],o=e("5530"),n=e("2f62"),c={data:function(){return{user:{nama:"",email:"",password:""},error:{nama:"",email:"",password:""}}},methods:Object(o["a"])(Object(o["a"])({},Object(n["b"])({register:"register"})),{},{cobaRegister:function(){var a=this;this.register(this.user).then((function(){a.$router.push("/profile")})).catch((function(r){a.error=r.response.data}))},hapusError:function(){this.error={nama:"",email:"",password:""}}})},l=c,i=e("2877"),u=e("6544"),d=e.n(u),p=e("8336"),f=e("b0af"),m=e("99d9"),b=e("62ad"),v=e("a523"),h=e("0fd9"),w=e("2fa4"),g=e("8654"),V=e("71d9"),x=e("2a7f"),k=Object(i["a"])(l,s,t,!1,null,null,null);r["default"]=k.exports;d()(k,{VBtn:p["a"],VCard:f["a"],VCardActions:m["a"],VCardText:m["b"],VCol:b["a"],VContainer:v["a"],VRow:h["a"],VSpacer:w["a"],VTextField:g["a"],VToolbar:V["a"],VToolbarTitle:x["a"]})}}]);
//# sourceMappingURL=chunk-2d0d6d35.ba1dabe0.js.map