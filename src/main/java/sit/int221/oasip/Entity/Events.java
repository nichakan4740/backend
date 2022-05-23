package sit.int221.oasip.Entity;

import lombok.Getter;
import lombok.Setter;

import javax.persistence.*;
import java.time.Instant;
import javax.persistence.Id;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.validation.constraints.Email;
import javax.validation.constraints.NotEmpty;
import javax.validation.constraints.NotNull;
import javax.validation.constraints.Size;


@Getter
@Setter
@Entity
@Table(name = "event")
public class Events {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "eventID", nullable = false)
    private Integer id;

    @NotEmpty
    @Size(min = 1 , max = 100 , message = "BookingName is not empty and must between 0 - 100")
    @Column(name = "bookingName", nullable = false, length = 100)
    private String bookingName;

    @NotEmpty
    @Email(message = "Error invalid email address")
    @Column(name = "eventEmail", length = 50)
    private String eventEmail;

    @Size(max = 500 , message = "Notes must between 0 - 500")
    @Column(name = "eventNotes", length = 500)
    private String eventNotes;

    @NotNull(message = "StartTime is not empty")
    @Column(name = "eventStartTime", nullable = false)
    private Instant eventStartTime;

    @NotNull(message = "Duration is not null")
    @Column(name = "eventDuration", nullable = false)
    private Integer eventDuration;

    //    @JsonIgnore
    @ManyToOne
    @JoinColumn(name = "eventCategoryID")
    private Categories eventCategoryID;

}