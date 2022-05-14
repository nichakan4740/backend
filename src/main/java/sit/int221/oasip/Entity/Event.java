package sit.int221.oasip.Entity;

import com.fasterxml.jackson.annotation.JsonIgnore;
import lombok.Getter;
import lombok.Setter;

import javax.persistence.*;
import java.time.Instant;
import javax.persistence.Id;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.validation.constraints.Email;
import javax.validation.constraints.NotEmpty;


@Getter
@Setter
@Entity
@Table(name = "event")
public class Event {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "eventID", nullable = false)
    private Integer id;

    @Column(name = "bookingName", nullable = false, length = 100)
    private String bookingName;

    @NotEmpty
    @Email
    @Column(name = "eventEmail", length = 50)
    private String eventEmail;

//    @Column(name = "eventCategory", nullable = false, length = 100)
//    private String eventCategory;

    @Column(name = "eventNotes", length = 500)
    private String eventNotes;

    @Column(name = "eventStartTime", nullable = false)
    private Instant eventStartTime;

//    @Column(name = "eventDuration", nullable = false)
//    private Integer eventDuration;


    //    @JsonIgnore
    @ManyToOne
    @JoinColumn(name = "eventCategoryID")
    private Eventcategory eventCategoryID;

//    @OneToOne(mappedBy = "event")
//    private Eventcategory eventcategory;

}