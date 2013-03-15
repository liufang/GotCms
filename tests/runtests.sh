:
: ${PHPUNIT:="phpunit"}
: ${PHPUNIT_OPTS:="--verbose"}
: ${PHPUNIT_GROUPS:=}

while [ -n "$1" ] ; do
  case "$1" in
    ALL|all)
     PHPUNIT_GROUPS=""
     break ;;

    Gc|Datatypes|Modules|ZfModules)
     PHPUNIT_GROUPS="${PHPUNIT_GROUPS:+"$PHPUNIT_GROUPS,"}$1"
     shift ;;
    *)

     PHPUNIT_FILE="$1"
     shift ;;
  esac
done

set -x
${PHPUNIT} ${PHPUNIT_OPTS} ${PHPUNIT_GROUPS:+--group $PHPUNIT_GROUPS} ${PHPUNIT_FILE}

