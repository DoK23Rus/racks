package main

import (
    "fmt"
    "strings"
    "flag"
    "log"
    "time"
    "os"
    "regexp"
    "context"
    "go.mongodb.org/mongo-driver/bson"
    "go.mongodb.org/mongo-driver/mongo"
    "go.mongodb.org/mongo-driver/mongo/options"
    "encoding/json"
    "text/tabwriter"
    "io"
)


const layoutISO string = "2006-01-02T15:04:05.000Z"
var mongoURI string = os.Getenv("MONGODB_URI")


func main() {
    // Default date range
    today := time.Now()
    tomorrow := time.Now().AddDate(0, 0, 1)
    defaultRange:= today.Format("2006-01-02") + 
        "_" + tomorrow.Format("2006-01-02")

    // Get falgs
    lastFlag := flag.Uint(
        "last", 
        100, 
        "number of entries, has less priority than -range flag")
    rangeFlag := flag.String(
        "range", 
        defaultRange, 
        "range of dates in YYYY-MM-DD_YYYY-MM-DD format")
    actionFlag := flag.String(
        "action", 
        "all", 
        "entry action - all|add|update|delete")
    flag.Parse()

    // Check lenth of range flag
    if len([]rune(*rangeFlag)) != 21 {
        fmt.Println("Wrong date range")
        os.Exit(1)
    }

    // Range flag regex check
    matched, _ := regexp.MatchString(
        `\d{4}-\d{2}-\d{2}_\d{4}-\d{2}-\d{2}`, 
        *rangeFlag)
    if matched == false {
        fmt.Println("Wrong date range")
        os.Exit(1)
    }

    // Monobgodb client connection
    client, err := mongo.
                        NewClient(options.Client().
                        ApplyURI(mongoURI))
    if err != nil {
        log.Fatal(err)
    }

    ctx := context.Background()
    err = client.Connect(ctx)
    if err != nil {
        log.Fatal(err)
    }

    defer client.Disconnect(ctx)
    demoDB := client.Database("mongolog")
    
    // Dates for date range
    dates := strings.Split(*rangeFlag, "_")
    startDate := dates[0] + "T00:00:00.000Z"
    endDate := dates[1] + "T00:00:00.000Z"
    startDateParse, _ := time.Parse(layoutISO, startDate) 
    endDateParse, _ := time.Parse(layoutISO, endDate)

    // Filter for date range
    filter := bson.D{
        {"$and",
            bson.A{
                bson.D{{"created", bson.D{{"$gt", startDateParse}}}},
                bson.D{{"created", bson.D{{"$lt", endDateParse}}}},
            },
        },
    }
    mongologCollection := demoDB.Collection("mongolog")
    opts := options.
                    Find().
                    SetSort(bson.D{{"created", -1}}).
                    SetLimit(int64(*lastFlag))

    cursor, err := mongologCollection.Find(ctx, filter, opts)
    if err != nil {
        log.Fatal(err)
    }
    
    var logs []bson.M

    if err = cursor.All(ctx, &logs); err != nil {
        log.Fatal(err)
    }

    // Get messages
    var messages []bson.M
    messages = getMessages(logs)

    // Filter and print entries
    sortMessages(messages, actionFlag)
}


// Get msg maps from log entries
func getMessages(logs []bson.M) ([]bson.M) {
    var msg []bson.M
    for _, doc := range logs {
        for key, value := range doc {
            if key == "msg" {
                val := value.(bson.M)
                msg = append(msg, val)
            }
        }
    }
    return msg
}


// Sort entries by action
func sortMessages(messages []bson.M, action *string) {
    var (
        separator string = strings.Repeat("-", 100)
        writer io.Writer = tabwriter.NewWriter(
            os.Stdout, 10, 0, 2, ' ', tabwriter.Debug)
    )
    for _, msg := range messages {
        if (msg["action"].(string) == "delete") && 
            (*action == "all" || *action == "delete") {
            printDelete(msg, separator, writer)
        } else if (msg["action"].(string) == "add") && 
            (*action == "all" || *action == "add") {
            printAdd(msg, separator, writer)
        } else if (msg["action"].(string) == "update") && 
            (*action == "all" || *action == "update") {
            printUpdate(msg, separator, writer)
        } else {
            fmt.Printf("")
        }
    }
}


// Print entries with "delete" action
func printDelete(msg bson.M, separator string, writer io.Writer) {
    var (
        time string = msg["time"].(string)
        user string = msg["user"].(string)
        action string = msg["action"].(string)
        modelName string = msg["model_name"].(string)
        objectName string = msg["object_name"].(string)
        pk string = msg["pk"].(string)
    )
    fmt.Fprint(writer, "DATE\tUSER\tACTION\tMODEL NAME\tOBJECT NAME\tPK\n")
    fmt.Fprintln(
        writer, time, "\t", user, "\t", 
        action, "\t", modelName, "\t", objectName, "\t", pk, "\n")
    fmt.Println(separator)
}


// Print entries with "add" action
func printAdd(msg bson.M, separator string, writer io.Writer) {
    var (
        time string = msg["time"].(string)
        user string = msg["user"].(string)
        action string = msg["action"].(string)
        modelName string = msg["model_name"].(string)
        fk string = msg["fk"].(string)
        newData bson.M = msg["new_data"].(bson.M)
    )
    marshalNewData, _ := json.MarshalIndent(newData, "", "    ")
    fmt.Fprint(writer, "DATE\tUSER\tACTION\tMODEL NAME\tFK\n")
    fmt.Fprint(
        writer, time, "\t", user, "\t", 
        action, "\t", modelName, "\t", fk, "\n\n")
    fmt.Fprint(writer, "*****NEW DATA*****\n")
    fmt.Fprint(writer, string(marshalNewData), "\n")
    fmt.Println(separator)
}


// Print entries with "update" action
func printUpdate(msg bson.M, separator string, writer io.Writer) {
    var (
        time string = msg["time"].(string)
        user string = msg["user"].(string)
        action string = msg["action"].(string)
        modelName string = msg["model_name"].(string)
        pk string = msg["pk"].(string)
        newData bson.M = msg["new_data"].(bson.M)
        oldData bson.M = msg["old_data"].(bson.M)
    )
    marshalOldData, _ := json.MarshalIndent(oldData, "", "    ")
    marshalNewData, _ := json.MarshalIndent(newData, "", "    ")
    fmt.Fprint(writer, "DATE\tUSER\tACTION\tMODEL NAME\tPK\n")
    fmt.Fprint(
        writer, time, "\t", user, "\t", 
        action, "\t", modelName, "\t", pk, "\n\n")
    fmt.Fprint(writer, "*****OLD DATA*****\n")
    fmt.Fprint(writer, string(marshalOldData), "\n\n")
    fmt.Fprint(writer, "*****NEW DATA*****\n")
    fmt.Fprint(writer, string(marshalNewData), "\n")
    fmt.Println(separator)
}