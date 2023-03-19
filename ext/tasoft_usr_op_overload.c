// include the PHP API itself
#include <php.h>
// then include the header of your extension
#include "tasoft_usr_op_overload.h"

#include <stdio.h>

// register our function to the PHP API
// so that PHP knows, which functions are in this module
zend_function_entry tasoft_usr_op_overload_functions[] = {
    {NULL, NULL, NULL}
};



static zend_class_entry *tasoft_class_entry = NULL;
static zend_object_handlers tasoft_class_handlers;

static const zend_function_entry uoo_functions[] = {
    PHP_FE_END
};

static zend_result my_operation(zend_uchar opcode, zval *result, zval *op1, zval *op2) {
    zval fn;

    switch (opcode) {
        case ZEND_ADD:
            ZVAL_STRING(&fn, "__add");
            break;
        case ZEND_SUB:
            ZVAL_STRING(&fn, "__sub");
            break;
        case ZEND_MUL:
            ZVAL_STRING(&fn, "__mul");
            break;
        case ZEND_DIV:
            ZVAL_STRING(&fn, "__div");
            break;
        case ZEND_MOD:
            ZVAL_STRING(&fn, "__mod");
            break;
        case ZEND_POW:
            ZVAL_STRING(&fn, "__pow");
            break;
        case ZEND_BW_OR:
            ZVAL_STRING(&fn, "__or");
            break;
        case ZEND_BW_AND:
            ZVAL_STRING(&fn, "__and");
            break;
        case ZEND_BW_XOR:
            ZVAL_STRING(&fn, "__xor");
            break;
        case ZEND_BW_NOT:
            ZVAL_STRING(&fn, "__not");
            break;
        case ZEND_CONCAT:
            ZVAL_STRING(&fn, "__cat");
            break;
        default:
            return FAILURE;
    }

    zval params[2];

    ZVAL_COPY_VALUE(&params[0], op1);
    ZVAL_COPY_VALUE(&params[1], op2);

    if(Z_TYPE_P(op1) == IS_OBJECT) {
        zend_object *obj = Z_OBJ_P(op1);
        if(zend_hash_exists(& obj->ce->function_table, fn.value.str))
            return _call_user_function_impl(op1, &fn, result, 2, params, NULL);
        return FAILURE;
    }
    else if(Z_TYPE_P(op2) == IS_OBJECT) {
        zend_object *obj = Z_OBJ_P(op2);
        if(zend_hash_exists(& obj->ce->function_table, fn.value.str))
            return _call_user_function_impl(op2, &fn, result, 2, params, NULL);
    }
    return FAILURE;
}

static int my_compare(zval *op1, zval *op2) {
    zval params[2];

    ZVAL_COPY_VALUE(&params[0], op1);
    ZVAL_COPY_VALUE(&params[1], op2);

    zval fn;
    ZVAL_STRING(&fn, "__compare");

    zval result;
    ZVAL_NULL(&result);

    if(Z_TYPE_P(op1) == IS_OBJECT) {
        _call_user_function_impl(op1, &fn, &result, 2, params, NULL);
    }
    else if(Z_TYPE_P(op2) == IS_OBJECT) {
        _call_user_function_impl(op2, &fn, &result, 2, params, NULL);
    }

    return (int) Z_LVAL(result);
}

static zend_object* test_create_object(zend_class_entry *class_type) {
    zend_object* zov;

    zov = emalloc(sizeof *zov);
    zend_object_std_init((zend_object *) zov, class_type);
    object_properties_init((zend_object*)zov, class_type);

    zend_objects_store_put(zov);
    zov->handlers = &tasoft_class_handlers;

    return zov;
}


PHP_MINIT_FUNCTION(tasoft_usr_op_overload_init)
{
#if defined(ZTS) && defined(COMPILE_DL_TEST)
    ZEND_TSRMLS_CACHE_UPDATE();
#endif

    zend_class_entry ce;
    INIT_CLASS_ENTRY(ce, "_UserOperationOverload", uoo_functions);
    tasoft_class_entry = zend_register_internal_class(&ce);

   tasoft_class_entry->create_object = test_create_object;

    memcpy(&tasoft_class_handlers, zend_get_std_object_handlers(), sizeof(tasoft_class_handlers));

    tasoft_class_handlers.do_operation = my_operation;
    tasoft_class_handlers.compare = my_compare;
    
    return SUCCESS;
}



// some pieces of information about our module
zend_module_entry tasoft_usr_op_overload_module_entry = {
    STANDARD_MODULE_HEADER,
    tasoft_usr_op_overload_EXTNAME,
    tasoft_usr_op_overload_functions,
    PHP_MINIT(tasoft_usr_op_overload_init),
    NULL,
    NULL,
    NULL,
    NULL,
    tasoft_usr_op_overload_VERSION,
    STANDARD_MODULE_PROPERTIES
};

ZEND_GET_MODULE(tasoft_usr_op_overload)
