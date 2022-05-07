package sit.int221.oasip.DTO;

import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import sit.int221.oasip.Entity.Eventcategory;

import javax.persistence.Column;
import java.sql.Timestamp;
import java.time.Instant;
import java.time.LocalTime;

@Getter
@Setter
@NoArgsConstructor
@AllArgsConstructor
public class EventDTO {
    private Integer id;
    private String bookingName;
    private String eventEmail;
//    private String eventCategory;
    private String eventNotes;
    private Instant eventStartTime;
    private Integer eventDuration;

//    @JsonIgnore
    private Eventcategory eventCategoryID;
}
