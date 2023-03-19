PHP_ARG_ENABLE(tasoft_usr_op_overload, Whether to enable the tasoft_usr_op_overload extension, [ --enable-tasoft_usr_op_overload Enable tasoft_usr_op_overload])

if test "$tasoft_usr_op_overload" != "no"; then
    PHP_NEW_EXTENSION(tasoft_usr_op_overload, tasoft_usr_op_overload.c, $ext_shared)
fi